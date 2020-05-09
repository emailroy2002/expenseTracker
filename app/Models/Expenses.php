<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    
    protected $guarded = ['created_at', 'updated_at'];

    public static function get_all_expenses() 
	{
        return Expenses::Join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
        ->select('expenses.id as id', 
        	'expenses.amount', 
        	'expenses.entry_date', 
        	'expenses.created_at', 
        	'expense_categories.name as expense_category_name', 
        	'expense_categories.id as expense_category_id')
        ->get();


    }

    public static function get_expense_summary() 
	{
        return Expenses::leftJoin('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
        ->select('expenses.id as id', 'expense_categories.name as expense_category_name','expenses.amount')->get();
    }
}
