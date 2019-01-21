<?php
namespace App\Repositories;

abstract class BaseRepository {

	protected $model;

	public function destroy($id)
	{
		$this->getById($id)->delete();
	}

	public function getById($id)
	{
		return $this->model->findOrFail($id);
	}

}
