<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table = 'images';
    protected $guarded = [];
}




// use App\Models\User;
// use App\Models\Product;
// use App\Models\Article;
// use App\Models\Image;

// class ImageController extends Controller
// {
//     public function store(Request $request)
//     {
//         // Assuming $request contains image file upload logic

//         // Store image for user
//         $user = User::find($userId);
//         $image = new Image();
//         $image->filename = $request->file('image')->store('images');
//         $user->images()->save($image);

//         // Store image for product
//         $product = Product::find($productId);
//         $image = new Image();
//         $image->filename = $request->file('image')->store('images');
//         $product->images()->save($image);

//         // Store image for article
//         $article = Article::find($articleId);
//         $image = new Image();
//         $image->filename = $request->file('image')->store('images');
//         $article->images()->save($image);

//         // Redirect back with success message
//         return back()->with('success', 'Image uploaded successfully.');
//     }
// }
