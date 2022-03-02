<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_Model extends CI_Model
{
    public $table = 'student';
	public $parenttable = 'parent';
	public $contacttable = 'contact';
    public $column = array('image','stdid', 'firstname','lastname','email','phone','gender','address','dob','subject','campus');
    public $order = array('id' => 'desc');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->search = '';
    }

    private function _get_datatables_query()
	{
		
		$this->db->from($this->table);

		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])
				($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
			$column[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

    function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

    function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

    public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

    public function get_by_id($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join($this->parenttable, 'student.stdid = parent.stdid', 'inner'); 
		$this->db->join($this->contacttable, 'student.stdid = contact.stdid', 'inner'); 
		$this->db->limit(1); 
		$query = $this->db->get();

		return $query->row();
	}

    public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function parentsave($data)
	{
		$this->db->insert($this->parenttable, $data);
		return $this->db->insert_id();
	}

	public function contactsave($data)
	{
		$this->db->insert($this->contacttable, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function parentupdate($where, $data)
	{
		$this->db->update($this->parenttable, $data, $where);
		return $this->db->affected_rows();
	}

	public function contactupdate($where, $data)
	{
		$this->db->update($this->contacttable, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		
		$this->db->where('student.stdid=parent.stdid');
		$this->db->where('student.stdid=contact.stdid');
		$this->db->where('student.id',$id);
		$this->db->delete('student','parent','contact');

		// $this->db->where('stdid', $id);
		// $this->db->delete($this->table);
		// $this->db->delete($this->parenttable);
		// $this->db->delete($this->contacttable);
	}

	public function get_by_id_view($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join($this->parenttable, 'student.stdid = parent.stdid', 'inner'); 
		$this->db->join($this->contacttable, 'student.stdid = contact.stdid', 'inner'); 
		// $this->db->where('id',$id);
		$this->db->limit(1); 
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$results = $query->result();
		}
		return $results;
	}
}