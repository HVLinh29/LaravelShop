@extends('admin_layout')
@section('admin_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê Video
            </div>
            <div class="row w3-res-tb">
                
               
                <div class="col-sm-12">
                    <div class="position-center">
                        <form>
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên video</label>
                                <input type="text" name="video_title" class="form-control video_title" onkeyup="ChangeToSlug();" id="slug" placeholder="Tên danh mục">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug Video</label>
                                <input type="text" name="video_slug" class="form-control video_slug" id="convert_slug" placeholder="Slug">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Link Video</label>
                                <input type="text" name="video_link" class="form-control video_link" id="convert_slug" placeholder="Slug">
                            </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả video</label>
                            <textarea style="resize: none"rows="5"  name="video_desc" class="form-control video_desc" 
                            id="exampleInputPassword1" ></textarea>
                        </div>
                    
                        <div class="form-group">
                            <label for="exampleInputPassword1">Hình ảnh video</label>
                            <input type="file" class="form-control" id="file_img_video" name="file" accept="image/*" multiple>
                         
                        </div>
                        <button type="button" name="add_video" class="btn btn-success btn-add-video">Thêm video</button>
                    </form>
                    <div id="notify">
                    </div>
                    </div>
                </div>
              </div>
            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>

                <div id ="video_load">
                </div>
            </div>

        </div>
        <!-- Modal -->
        <div class="modal fade" id="video_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tên video</h5>
                        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> --}}
                    </div>
                    <div class="modal-body">
                        Video ở đây
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
