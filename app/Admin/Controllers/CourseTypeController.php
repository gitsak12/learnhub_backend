<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\CourseType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use Encore\Admin\Tree;

class CourseTypeController extends AdminController
{
    //this is used for showing tree form of the items means draggable
    //if the below code is not there we can easily add items of Course type
    // in the database and it access them
    public function index(Content $content)
    {
        $tree = new Tree(new CourseType);
        return $content->header('Course Types')->body($tree);
    }

    //just for view
    public function detail($id)
    {
        $show = new Show(CourseType::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('title', __("Category"));
        $show->field('description', __('Description'));
        $show->field('order', __('Order'));
        $show->field('created_at', __('Created_at'));
        $show->field('updated_at', __('Updated_at'));
        //$show->disableActions();
        // $show->disableCreateButton();
        // $show->disableExport();
        // $show->disableFilter();

        return $show;

    }

    //its get called when you create a new form or edit a form
    protected function form()
    {
        $form = new Form(new CourseType());
        $form->select('parent_id', __('Parent Category'))
            ->options((new CourseType)::selectOptions());

        $form->text('title', __('Title')); //text is similar to string in laravel
        $form->textarea('description', __('Description')); //textArea is similar to text
        $form->number('order', __('Order')); // number is similar to int

        return $form;
    }
}
