@extends('site.layout')
@section('title')
    Edit post
@stop
@section('content')
    <form method="post" role="form" enctype="multipart/form-data" class="post_form">
    {!! csrf_field() !!}
    <!-- Title and Publish Buttons -->
        <div class="row">
            <div class="col-sm-12 @if(!empty($errors->first('title'))) has-error @endif">
                <input type="text" value="{{$post->title}}" class="form-control input-lg" id="post_title"
                       name="title" placeholder="Post title"/>
                <p class="error">{{$errors->first('title')}}</p>
            </div>
            <div class="col-sm-12 post_alias_block @if(!empty($errors->first('alias'))) has-error @endif">
                <input type="text" value="{{$post->alias}}" class="form-control input-lg" id="post_alias"
                       name="alias" placeholder="Post Alias"/>
                <p class="error">{{$errors->first('alias')}}</p>
            </div>
        </div>

        <br/>

        <!-- WYSIWYG - Content Editor -->
        <div class="row">
            <div class="col-sm-12 @if(!empty($errors->first('content'))) has-error @endif">
                <textarea class="form-control wysihtml5" rows="18" data-stylesheet-url="assets/css/wysihtml5-color.css"
                          name="content" id="post_content">{{$post->content}}</textarea>
                <p class="error">{{$errors->first('content')}}</p>
            </div>
        </div>

        <br/>
        <!-- Metabox :: SEO part -->
        <div class="col-sm-12 seo_part">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        SEO part
                    </div>

                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>

                <div class="panel-body">

                    <p>Meta keys</p>
                    <input type="text" value="{{$post->meta_keys}}" placeholder="Meta keys" id="post_meta_keys"
                           name="meta_keys"
                           class="form-control"/>

                </div>

                <div class="panel-body">

                    <p>Meta Description</p>
                    <textarea type="text" placeholder="Meta description" id="post_meta_desc" name="meta_desc"
                              class="form-control">{{$post->meta_desc}}</textarea>

                </div>
            </div>

        </div>
        <!-- Metaboxes -->
        <div class="row">

            <!-- Metabox :: Publish Settings -->
            <div class="col-sm-4">

                <div class="panel panel-primary" data-collapsed="0">

                    <div class="panel-heading">
                        <div class="panel-title">
                            Publish Settings
                        </div>

                        <div class="panel-options">
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div>
                            <input type="checkbox" @if($post->publish==1) {{'checked'}} @endif id="post_publish"
                                   name="publish">
                            <label for="post_publish">Publish</label>
                        </div>

                    </div>

                </div>

            </div>


            <!-- Metabox :: Featured Image -->
            <div class="col-sm-4">

                <div class="panel panel-primary" data-collapsed="0">

                    <div class="panel-heading">
                        <div class="panel-title">
                            Featured Image
                        </div>

                        <div class="panel-options">
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="max-width: 310px;"
                                 data-trigger="fileinput">
                                @if(empty($post->image))
                                    <img src="/assets/admin/images/320x160.png">
                                @else
                                    <img src="{{asset('storage/uploads/'.$post['image'])}}">
                                @endif
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail"
                                 style="max-width: 320px; max-height: 160px">
                            </div>
                            <div>
									<span class="btn btn-white btn-file">
										<span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
										<input type="file" name="image" id="post_image" accept="image/*">
									</span>
                                <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                        <p class="error">{{$errors->first('image')}}</p>

                    </div>

                </div>

            </div>

            <!-- Metabox :: Categories -->
            <div class="col-sm-4">

                <div class="panel panel-primary" data-collapsed="0">

                    <div class="panel-heading">
                        <div class="panel-title">
                            Categories
                        </div>

                        <div class="panel-options">
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>

                    <div class="panel-body">
                        @if(!$categories->isEmpty())
                            <select name="category" id="post_category" class="form-control">
                                <option value="">Select category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category['id']}}"
                                    @if($category['id']==$post->category_id) {{'selected'}} @endif>{{$category['name']}}</option>
                                @endforeach
                            </select>
                        @else
                            <p>No Categories</p>
                        @endif
                    </div>

                </div>

            </div>
            <div class="clear"></div>

            <!-- Metabox :: Tags -->
            <div class="col-sm-12">

                <div class="panel panel-primary" data-collapsed="0">

                    <div class="panel-heading">
                        <div class="panel-title">
                            Tags
                        </div>

                        <div class="panel-options">
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if(!$tags->isEmpty())
                            <p>Add Post Tags</p>
                            <select data-placeholder="Select tag" style="width:350px;" multiple
                                    class="chosen-select tags" name="tags[]">
                                @foreach($tags as $tag)
                                    <?php
                                    $selected = false;
                                    if ($post->tags->contains($tag['id'])) {
                                        $selected = true;
                                    }
                                    ?>
                                    <option value="{{$tag['id']}}"
                                            @if($selected) selected @endif>{{$tag['name']}}</option>
                                @endforeach
                            </select>
                        @else
                            <p>No tags</p>
                        @endif
                    </div>

                </div>

            </div>

        </div>
        <input type="submit">
    </form>
@stop