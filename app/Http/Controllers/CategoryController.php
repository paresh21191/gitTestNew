<?php
namespace App\Http\Controllers;
    
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
    
class CategoryController extends Controller
{ 
    function __construct()
    {
         $this->middleware('permission:Category-list|Category-create|Category-edit|Category-delete', ['only' => ['index','show']]);
         $this->middleware('permission:Category-create', ['only' => ['create','store']]);
         $this->middleware('permission:Category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:Category-delete', ['only' => ['destroy']]);
    }

    public function categoryIndex(): View
    {
        $categorys = Category::latest()->paginate(5);
         return view('categorys.index',compact('categorys'));
    }
    
     public function create(): View
    {
        return view('categorys.create');
    }
    
     public function store(Request $request): RedirectResponse
    {
         request()->validate([
            'name' => 'required|unique:categories,name',
         ]);
    
    
        Category::create($request->all());
    
        return redirect()->route('category')
                        ->with('success','Category created successfully.');
    }
 
    public function edit(Category $Category): View
    {
        return view('categorys.edit',compact('Category'));
    }
    public function update(Request $request, Category $Category): RedirectResponse
    {
         request()->validate([
            'name' => 'required|unique:categories,name',
         ]);
    
        $Category->update($request->all());
    
        return redirect()->route('categorys.index')
                        ->with('success','Category updated successfully');
    }
    
    public function destroy(Category $Category): RedirectResponse
    {
        $Category->delete();   
        return redirect()->route('categorys.index')
                        ->with('success','Category deleted successfully');
    }
}