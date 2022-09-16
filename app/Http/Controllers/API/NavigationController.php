<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Homepage;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class NavigationController extends Controller
{
    // get navigation header ,footer,footer menu bottom

    public function header(Request $request)
    {
        $data = [];
        $validator = Validator::make($request->all(), [ 
            'menu_type' => 'required|integer',
        ]);
        if ($validator->fails()) 
        { 
            return response()->json(['errors'=>$validator->errors()], 403);            
        }
        $menuData = Menu::where('menu_type',$request->menu_type)->where('parent_id','==',0)->with('getChilds')->get();

        foreach($menuData as $k=> $menu)
        {
            $data[$k]['menu_title']= $menu->getType->title;
            $data[$k]['id']=$menu->id;
            $data[$k]['menu_type']=$menu->menu_type;
            $data[$k]['title']=$menu->title;
            $data[$k]['link']=$menu->link;
            $data[$k]['parent_id']=$menu->parent_id;
            if(count($menu->getChilds) > 0)
            {
                $data[$k]['childs']=$menu->getChilds;
            }

        }
        return response()->json(["success" => true, "message" => 'Navigation header' ,"data"=> $data], 200);
    }

    public function homePage(Request $request)
    {
        $homepage = Homepage::get();
        $settings = Setting::first();
        if($homepage)
        {
            foreach($homepage as $k=> $home)
            {
                $data[$k]['home_page']['id'] =$home->id;
                $data[$k]['home_page']['about_logo'] =$home->about_logo;
                $data[$k]['home_page']['about_title'] =$home->about_title;
                $data[$k]['home_page']['about_title_first'] = implode(' ', array_slice(explode(' ', $home->about_title), 0, 2));
                $data[$k]['home_page']['about_title_last'] =implode(' ', array_slice(explode(' ', $home->about_title), 2, 5));
                $data[$k]['home_page']['about_subtile'] =$home->about_subtile;
                $data[$k]['home_page']['about_button_text'] =$home->about_button_text;
                $data[$k]['home_page']['about_button_link'] =$home->about_button_link;

                $data[$k]['home_page']['trigalight_title'] =$home->trigalight_title;
                $data[$k]['home_page']['trigalight_subtitle'] =$home->trigalight_subtitle;
                $data[$k]['home_page']['trigalight_content'] = htmlspecialchars_decode($home->trigalight_content);
                $data[$k]['home_page']['trigalight_background_image'] =$home->trigalight_background_image;
                $data[$k]['home_page']['trigalight_title_image'] =$home->trigalight_title_image;
                $data[$k]['home_page']['trigalight_first_image'] =$home->trigalight_first_image;
                $data[$k]['home_page']['trigalight_second_image'] =$home->trigalight_second_image;

                $data[$k]['home_page']['home_video'] =$home->home_video;

                $data[$k]['home_page']['feat_col_first_title'] =$home->feat_col_first_title;
                $data[$k]['home_page']['feat_col_first_title_first'] =implode(' ', array_slice(explode(' ', $home->feat_col_first_title), 0, 1));
                $data[$k]['home_page']['feat_col_first_title_last'] =implode(' ', array_slice(explode(' ', $home->feat_col_first_title), 1, 2));

                $data[$k]['home_page']['feat_col_first_subtitle'] =$home->feat_col_first_subtitle;
                $data[$k]['home_page']['feat_col_first_btn_link'] =$home->feat_col_first_btn_link;
                $data[$k]['home_page']['feat_col_first_btn_label'] =$home->feat_col_first_btn_label;
                $data[$k]['home_page']['feat_col_first_image'] =$home->feat_col_first_image;

                $data[$k]['home_page']['feat_col_sec_title'] =$home->feat_col_sec_title;
                $data[$k]['home_page']['feat_col_sec_title_first'] =implode(' ', array_slice(explode(' ', $home->feat_col_sec_title), 0, 1));
                $data[$k]['home_page']['feat_col_sec_title_last'] =implode(' ', array_slice(explode(' ', $home->feat_col_sec_title), 1, 2));

                $data[$k]['home_page']['feat_col_sec_subtitle'] =$home->feat_col_sec_subtitle;
                $data[$k]['home_page']['feat_col_sec_btn_link'] =$home->feat_col_sec_btn_link;
                $data[$k]['home_page']['feat_col_sec_btn_label'] =$home->feat_col_sec_btn_label;
                $data[$k]['home_page']['feat_col_sec_image'] =$home->feat_col_sec_image;

                $data[$k]['home_page']['catalogue_logo'] =$home->catalogue_logo;
                $data[$k]['home_page']['catalogue_subtitle'] =$home->catalogue_subtitle;
                $data[$k]['home_page']['catalogue_content'] =htmlspecialchars_decode($home->catalogue_content);
                $data[$k]['home_page']['catalogue_btn_label'] =$home->catalogue_btn_label;
                $data[$k]['home_page']['catalogue_btn_link'] =$settings->catalogue;

                $data[$k]['home_page']['parallax_content'] =htmlspecialchars_decode($home->parallax_content);
                $data[$k]['home_page']['parallax_back_image'] =$home->parallax_back_image;
                $data[$k]['home_page']['parallax_first_img'] =$home->parallax_first_img;
                $data[$k]['home_page']['parallax_sec_img'] =$home->parallax_sec_img;
                $data[$k]['home_page']['parallax_third_img'] =$home->parallax_third_img;

                $data[$k]['home_page']['strap_sec_title'] =$home->strap_sec_title;
                $data[$k]['home_page']['strap_sec_title_first'] =implode(' ', array_slice(explode(' ', $home->strap_sec_title), 0, 1));
                $data[$k]['home_page']['strap_sec_title_middle'] =implode(' ', array_slice(explode(' ', $home->strap_sec_title), 1, 1));
                $data[$k]['home_page']['strap_sec_title_last'] =implode(' ', array_slice(explode(' ', $home->strap_sec_title), 2, 3));
                $data[$k]['home_page']['strap_sec_image'] =$home->strap_sec_image;
                $data[$k]['home_page']['strap_sec_content'] =htmlspecialchars_decode($home->strap_sec_content);
                $data[$k]['home_page']['strap_sec_btn_label'] =$home->strap_sec_btn_label;
                $data[$k]['home_page']['strap_sec_btn_link'] =$home->strap_sec_btn_link;
            }
            return response()->json(["success" => true, "message" => 'Home Page.' ,"data"=>$data], 200);
        }else
        { 
            return response()->json(["success" => false, "message" => 'No Data'], 202);
        }
    }
}
