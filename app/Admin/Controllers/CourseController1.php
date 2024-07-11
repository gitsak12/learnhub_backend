<?php

namespace App\Admin\Controllers;


use App\Models\Course;
use App\Models\CourseType;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;


class CourseController1 extends AdminController
{
    //this is used for showing tree form of the items means draggable
    //if the below code is not there we can easily add items of Course type
    // in the database and it access them
    // public function index(Content $content)
    // {
    //     $tree = new Tree(new CourseType);
    //     return $content->header('Course Types')->body($tree);
    // }

    protected function grid()
    {




        $grid = new Grid(new Course());
        // if(Admin::user()->isRole('teacher'))
        // {
        //     $token = Admin::user()->token;
        //     $grid->model()->where('user_token', '=', $token);
        // }

        $grid->column('id', __('Id'));
        $grid->column('user_token', __('Teachers'))->display(
            function ($token) {
                //value function returns a specific field from the match
                //return DB::table("admin_users")->where('token', '=', $token)->value('username');
            }
        );
        $grid->column('name', __('Name'));
        $grid->column('thumbnail', __('Thumbnail'))->image('', 200, 200);
        $grid->column('description', __('Description'));
        $grid->column('type_id', __('Type id'));
        $grid->column('price', __('Price'));
        $grid->column('lesson_num', __('Lesson num'));
        $grid->column('video_length', __('Video length'));

        $grid->column('created_at', __('Created at'));


        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Course::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('thumbnail', __('Thumbnail'));
        $show->field('video', __('Video'));
        $show->field('description', __('Description'));
        $show->field('price', __('Price'));
        $show->field('lesson_num', __('Lesson num'));
        $show->field('video_length', __('Video length'));
        $show->field('follow', __('Follow'));
        $show->field('score', __('Score'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }


    //its get called when you create a new form or edit a form
    protected function form()
    {
        $form = new Form(new Course());
        $form->text('name', __('Name'));
        //get category from course type;
        $result = CourseType::pluck('title');
        $form->select('type_id', __('Category'))->options($result);
        // this will give me all the objects in CourseType
        // so i can pass any databasse column name and it will return it in key value pair
        //see screenshot left side param becomes key and other one is id
        //$result = CourseType::pluck('title', 'id');

        // $form->select('parent_id', __('Parent Category'))
        //     ->options((new Course)::selectOptions());
        $form->image('thumbnail', __('Thumbnail'))->uniqueName();
        //file: video, pdf, doc
        $form->file('video', __('Video'))->uniqueName();

        $form->textarea('description', __('Description')); //textArea is similar to text
        $form->decimal('price', __('Price')); // number is similar to int
        $form->number('lesson_num', __("Lesson Number"));
        $form->number('video_length', __('Video Length'));





        //to check who is posting
        $result = User::pluck('name', 'token');
        $form->select('user_token', __('Teacher'))->options($result);

        // if(Admin::user()->isRole('teacher'))
        // {
        //     $token = Admin::user()->token;
        //     $username = Admin::user()->username;
        //     $form->select('user_token', __('Teacher'))->options([$token=>$username])->default($token)->readonly();
        // }
        // else
        // {
        //     $result = DB::table('admin_users')->pluck('name', 'token');
        //     $form->select('user_token', __('Teacher'))->options($result);
        // }


        $form->display('created_at', __('Created At'));
        $form->display('updated_at', __('Updated At'));
        $form->switch('recommended', __('Recommended'))->default(0);

        return $form;
    }
}
