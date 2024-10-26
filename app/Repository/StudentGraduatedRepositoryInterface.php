<?php


namespace App\Repository;


interface StudentGraduatedRepositoryInterface
{
    public function index();

    public function SoftDelete($request);

    public function create();

    public function destroy($request);
    

}
