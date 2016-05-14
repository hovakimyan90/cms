@extends('admin.layout')
@section('content')
    <h1 class="margin-bottom">Edit Post</h1>
    <ol class="breadcrumb bc-3">
        <li>
            <a href="{{config('app.admin_path')}}/posts">Posts</a>
        </li>
        <li class="active">
            <strong>Edit Post</strong>
        </li>
    </ol>
    <h2>Edit Post</h2>
    <br/>

    <style>
        .ms-container .ms-list {
            width: 135px;
            height: 205px;
        }

        .post-save-changes {
            float: right;
        }

        @media screen and (max-width: 789px) {
            .post-save-changes {
                float: none;
                margin-bottom: 20px;
            }
        }
    </style>

    <form method="post" role="form" enctype="multipart/form-data" class="post_form">
        {!! csrf_field() !!}
                <!-- Title and Publish Buttons -->
        <div class="row">
            <div class="col-sm-2 post-save-changes">
                <button type="submit" class="btn btn-green btn-lg btn-block btn-icon">
                    Publish
                    <i class="entypo-check"></i>
                </button>
            </div>

            <div class="col-sm-10 @if(!empty($errors->first('title'))) has-error @endif">
                <input type="text" value="{{$post->title}}" class="form-control input-lg" id="post_title"
                       name="title" placeholder="Post title"/>
                <p class="error">{{$errors->first('title')}}</p>
            </div>
            <div class="col-sm-10 post_alias_block @if(!empty($errors->first('alias'))) has-error @endif">
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
                            <div class="fileinput-new thumbnail" style="max-width: 310px; height: 160px;"
                                 data-trigger="fileinput">

                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail"
                                 style="max-width: 320px; max-height: 160px">
                                @if(empty($post->image))
                                    <img src="/public/assets/admin/images/320x160.png">
                                @else
                                    <img src="/public/uploads/{{$post->image}}">
                                @endif
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
                        @if(!empty($categories))
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
                        <p>Add Post Tags</p>
                        <?php
                        $i = 0;
                        ?>
                        <select data-placeholder="Select tag" style="width:350px;" multiple
                                class="chosen-select tags" name="tags[]">
                            <?php
                            $i = 0;
                            ?>
                            @foreach($tags as $tag)
                                <option value="{{$tag->id}}" @if($post->tags->contains('id',$tag->id)) {{'selected'}} @endif>{{$tag->name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>

        </div>

    </form>
@stop