<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ContactModel;
use App\Models\GroupModel;

class Contacts extends ResourceController
{
  protected $helpers = ['custom'];

  function __construct()
  {
    $this->contact = new ContactModel();
    $this->group = new GroupModel();
  }
  /**
   * Return an array of resource objects, themselves in array format
   *
   * @return mixed
   */
  public function index()
  {
    $data['contacts'] = $this->contact->getAll();
    return view('contact/index', $data);
  }

  /**
   * Return the properties of a resource object
   *
   * @return mixed
   */
  public function show($id = null)
  {
    //
  }

  /**
   * Return a new resource object, with default properties
   *
   * @return mixed
   */
  public function new()
  {
    $data['groups'] = $this->group->findAll();
    return view('contact/new', $data);
  }

  /**
   * Create a new resource object, from "posted" parameters
   *
   * @return mixed
   */
  public function create()
  {
    $data = $this->request->getPost();
    $save = $this->contact->insert($data);

    if (!$save) {
      return redirect()
        ->back()
        ->withInput()
        ->with('errors', $this->contact->errors());
    } else {
      return redirect()
        ->to('/contacts')
        ->with('success', '! Data berhasil ditambahkan');
    }
  }

  /**
   * Return the editable properties of a resource object
   *
   * @return mixed
   */
  public function edit($id = null)
  {
    $contact = $this->contact->find($id);
    if (is_object($contact)) {
      $data['contact'] = $contact;
      $data['groups'] = $this->group->findAll();
      return view('contact/edit', $data);
    } else {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
  }

  /**
   * Add or update a model resource, from "posted" properties
   *
   * @return mixed
   */
  public function update($id = null)
  {
    $data = $this->request->getPost();
    $save = $this->contact->update($id, $data);
    if (!$save) {
      return redirect()
        ->back()
        ->withInput()
        ->with('errors', $this->contact->errors());
    } else {
      return redirect()
        ->to('/contacts')
        ->with('success', '! Data berhasil diupdate');
    }
  }

  /**
   * Delete the designated resource object from the model
   *
   * @return mixed
   */
  public function delete($id = null)
  {
    $this->contact->delete($id);
    return redirect()
      ->to('/contacts')
      ->with('success', '! Data berhasil dihapus');
  }
}
