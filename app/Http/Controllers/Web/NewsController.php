<?php
/**
 * Front End: News
 *
 * To display a list of all the news.
 *
 * @package  adr_dgda/web
 * @author   Mayeenul Islam
 */

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Trans\NewsModel;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public $lang;

    public function __construct()
    {
        $this->lang = Session::get("locale");
        if (!isset($this->lang)) {
            $this->lang = config('app.locale');
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return the View of news list.
     */
    public function index()
    {
    	//fetch only the data of type 'news'
        $allNews = NewsModel::where('type', 'news')
            ->where('status', 1)
        	->orderBy('published_dt', 'desc')
            ->select('id','title', 'details', 'published_dt')
            ->paginate(6);

        //fetch only the data of type 'events'
        $events = NewsModel::where('type', 'events')
        	->where('status', 1)
        	->orderBy('published_dt', 'desc')
            ->select('id','title')
            ->paginate(5);

        return view('web.news', compact('allNews', 'events'));
    }


    /**
     * Display single news/event
     *
     * @return the View of a single news/event.
     */
    public function show( $id )
    {

    	//fetch only the data of type 'news' that has the ID
        $item = NewsModel::where('status', 1)
            ->where('id', $id)
            ->select('id','title', 'details', 'type', 'published_dt')
            ->get();
    	
    	if( is_null($item) ) {
    		abort(404);
    	}

        //fetch only the data of type 'events'
        $events = NewsModel::where('type', 'events')
        	->where('status', 1)
        	->orderBy('published_dt', 'desc')
            ->select('id','title')
            ->paginate(5);

        return view('web.newsdetail', compact('item', 'events'));
    }
}
