<?php

namespace App\Traits;

trait File
{

    public $settingsPath = 'public/uploads/settings/';
    public $categoriesPath = 'public/uploads/categories/';
    public $subCategoriesPath = 'public/uploads/sub-categories/';
    public $productsPath = 'public/uploads/products/';
    public $usersPath = 'public/uploads/users/';
    public $projectPath = 'public/uploads/project/';
  /**
   * path with file name
   * return delete
   */

  public function uploadFile($request, $path, $inputName)
  {

    // get file extenstion
    $fileExt = $request->file($inputName)->getClientOriginalExtension();
    $fileName = pathinfo($request->file($inputName)->getClientOriginalName())['filename'];
    // rename the filename
    $fileName = $fileName . '-' . time() . '.' . $fileExt;
    // move the file to path the you are passed it into the argument on this fn..
    $request->file($inputName)->move($path, $fileName);
    // retrun the stored file with path !
    $storedFileName = $path . $fileName;
    return $storedFileName;
  }

  public function uploadFiles($file, $path) {
    // get file extenstion
    $fileName = pathinfo($file->getClientOriginalName())['filename'];
    $fileExt = $file->getClientOriginalExtension();
    // rename the filename
    $fileName = $fileName . '-' . time() . '.' . $fileExt;
    // move the file to path the you are passed it into the argument on this fn..
    $file->move($path, $fileName);
    // retrun the stored file with path !
    $storedFileName = $path . $fileName;
    return $storedFileName;
  }


  public function rename($request,$model, $name) {
      // array of folders of image file
      $arrayOfFoldersAndFiles = explode('/', $model->image);
      $arrayOfFoldersOnly = explode('/', dirname($model->image));
      $index = array_search($model->name_en, $arrayOfFoldersAndFiles);
      if($index) {
          $arrayOfFoldersAndFiles[$index] = $request->name_en;
          $arrayOfFoldersOnly[$index] = $request->name_en;
          // rename the directory name of the image
          rename(dirname($model->image), implode('/',$arrayOfFoldersOnly));
          $model->update([
            $name => implode('/',$arrayOfFoldersAndFiles)
          ]);
      }
  }
}
