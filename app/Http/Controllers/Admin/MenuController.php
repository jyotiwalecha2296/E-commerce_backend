<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuType;
class MenuController extends Controller
{
    public function index(){
    	$data = MenuType::get();       
        if($data->count() > 0){
        	foreach($data as $detail){
        		$detail['menu'] = Menu::where('menu_type',$detail->id)->where('parent_id', '=', 0)->get();        		 
        	}           
        } 

        return view('admin.menu.index',compact('data'));
    }


    public function create($id){
        $menus = Menu::where('parent_id', '=', 0)->where('menu_type',$id)->get();
        $allMenus = Menu::where('menu_type',$id)->get();
        $menu_type = MenuType::where('id',$id)->first();  
        return view('admin.menu.addmenu')->with('menus',$menus)->with('allMenus',$allMenus)->with('menu_type',$menu_type);
    }

     

    public function store(Request $request){
        $request->validate([
           'title' => 'required',
        ]);
        $input = $request->all();
        $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
        $savedata = new Menu();
        $savedata->menu_type = $request->menu_type; 
        $savedata->title = $request->title;  
        $savedata->parent_id = $input['parent_id'] ;
        $savedata->link = $request->link;     
        $savedata->save();
        return back()->with('success', 'Menu added successfully.');
    }


    public function edit($id){
        $menus = Menu::where('parent_id', '=', 0)->where('menu_type',$id)->orderBy('order','ASC')->get();
        $allMenus = Menu::where('menu_type',$id)->orderBy('order','ASC')->get();

        $menu_type = MenuType::where('id',$id)->first(); 
        return view('admin.menu.editmenu')->with('menus',$menus)
                                          ->with('allMenus',$allMenus)
                                          ->with('menu_type',$menu_type);
    }

    public function update(Request $request){
        $request->validate([
           'menu_id' => 'required'
        ]);
        $input = $request->all();
        $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];

        $savedata = Menu::find($request->menu_id);       
        $savedata->title = $request->title;  
        $savedata->parent_id = $input['parent_id'] ;
        $savedata->link = $request->link;     
        $savedata->save();
        return back()->with('success', 'Menu Updated successfully.');
    }


    public function delete(Request $request){
        $request->validate([
           'menu_id' => 'required'
        ]);
         
         $check_submenus=Menu::where('parent_id',$request->menu_id)->get();
         if($check_submenus->count() > 0){
         	foreach($check_submenus as $check_submenu){
         		$updatedata =Menu::find($check_submenu->id);       
		        $updatedata->parent_id = "0";  		         
		        $updatedata->save();
         	}
         }
         Menu::where('id',$request->menu_id)->delete();
        return back()->with('success', 'Menu deleted successfully.');
    }

    // to sort the order of the menu

    public function sort(Request $request)
    {
        $allMenus = Menu::get();

        foreach ($allMenus as $menu) 
        {
            foreach ($request->order as $order) 
            {
                if ($order['id'] == $menu->id) 
                {
                    $menu->update(['order' => $order['position']]);
                }
            }
        }        
        return response('Update Successfully.', 200);
    }
}
