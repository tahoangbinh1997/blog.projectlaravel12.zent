<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
             // tiêu đề bài viết
            $table->string('title')->index();
             // ảnh thu nhỏ của bài viết
            $table->string('thumbnail')->nullable();
            // mô tả ngắn cho bài viết
            $table->mediumText('description')->nullable(); 
             // nội dung bài viết
            $table->longText('content')->nullable();
            // đường đẫn - title không dấu, và nối liền nhau bằng dấu -
            $table->string('slug')->unique(); 
            //  id của người viết bài
            $table->integer('user_id')->unsigned(); 
             // id của danh mục mà bài viết đang đứng
            $table->integer('category_id')->unsigned();
           // đếm lượt xem bài viết
            $table->integer('view_count')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
