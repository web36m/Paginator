<?php

/**
 * Paginator
 * @author Shilov Vasiliy
 */
class Paginator {

	private $page;
	private $limit;
	private $max;
	private $total;

	public function init($page = 0, $limit = 10, $max = 10, $total = 0) {
		$o = new self();
		$o->page = $page;
		$o->limit = $limit;
		$o->max = $max-1;
		$o->total = $total;
		return $o->get();
	}

	public function get() {
		if ($this->limit >= $this->total)
			return NULL;
		elseif ($this->total / $this->limit < $this->max)
			return $this->offFirstLast();
		else
			return $this->onFirstLast();
	}

	private function offFirstLast() {
		$return = array();
		if ($this->page > 0)
			$return['prev'] = array(
				'page' => $this->page - 1,
				'current' => false,
			);
		for ($p = 0; $p < ceil($this->total / $this->limit); $p++) {
			$return[$p + 1] = array(
				'page' => $p,
				'current' => ($p == $this->page) ? true : false,
			);
		}
		if ($this->page < ceil($this->total / $this->limit)-1)
			$return['next'] = array(
				'page' => $this->page + 1,
				'current' => false,
			);
		return $return;
	}

	private function onFirstLast() {
		$return = array();
		$amp = $this->max / 2;
		$start = 0;
		if ($this->page <= $amp) {
			$start = 0;
		} elseif ($this->page >= ceil($this->total / $this->limit) - $amp) {
			$start = ceil($this->total / $this->limit) - $this->max;
		} else {
			$start = $this->page - $amp;
		}
		if ($this->page > 0) {
			$return['first'] = array(
				'page' => 0,
				'current' => false,
			);
			$return['prev'] = array(
				'page' => $this->page - 1,
				'current' => false,
			);
		}
		for ($p = $start; $p < $start + $this->max; $p++) {
			$return[$p + 1] = array(
				'page' => $p,
				'current' => ($p == $this->page) ? true : false,
			);
		}
		if ($this->page < ceil($this->total / $this->limit) - 1) {
			$return['next'] = array(
				'page' => $this->page + 1,
				'current' => false,
			);
			$return['last'] = array(
				'page' => ceil($this->total / $this->limit),
				'current' => false,
			);
		}
		return $return;
	}

	static function translate($value, $options = array()) {
		return (is_array($options) && isset($options[$value])) ? $options[$value] : $value;
	}

}