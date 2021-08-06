@extends('users.layouts.index')
@section('content')
@include('users.title.review.header')
<h1> {{__('message.Show_Review')}}</h1>
@include('users.title.body')
<li> <span class="ion-ios-arrow-right"></span> {{__('message.Show_Review')}}</li>
@include('users.title.footer')
<div class="page-single">
   <div class="container">
      <div class="row ipad-width">
         <div class="row">
            <div class="col-md-9 col-sm-12 col-xs-12">
               <div class="blog-detail-ct">
                  <h1>{{$review->title}}</h1>
                  <span class="time">{{$review->created_at}}</span>
                  <div class="flex-it flex-ct">
                     <p>
                        {{$review->body}}
                     </p>
                  </div>
                  <!-- share link -->
                  <div class="flex-it share-tag">
                     <div class="social-link">
                        <h4>{{__('message.Share_it')}}</h4>
                        <a href="#"><i class="ion-social-facebook"></i></a>
                        <a href="#"><i class="ion-social-twitter"></i></a>
                        <a href="#"><i class="ion-social-googleplus"></i></a>
                        <a href="#"><i class="ion-social-pinterest"></i></a>
                        <a href="#"><i class="ion-social-linkedin"></i></a>
                     </div>
                     <div class="right-it">
                        <h4>{{__('message.Tags')}}</h4>
                        <a href="#">{{__('message.'.$categorys->title)}},</a>
                     </div>
                  </div>
                  <!-- comment items -->
                  <div class="comments">
                     <h4>{{$totalcomment}} {{__('message.Comments')}}</h4>
                     @foreach($comments as $comment)
                     <div class="cmt-item flex-it">
                        <div class="author-infor" >
                           <div class="flex-it2">
                              <h6><a href="#">
                                    {{$comment->user()->value('name')}} 
                                 </a>
                              </h6>
                              <span class="time"> {{$comment->created_at}}</span>
                           </div>
                           <p>{{$comment->body}}</p>
                           <div>
                              <p>
                                 <a class="rep-btn" href="{{url('comment/'.$comment->id.'/edit')}}">{{__('message.Edit')}}</a>
                              </p>
                              <p>
                              <form action="{{url('comment/'.$comment->id)}}" class="user" method="post">
                                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                 @method('DELETE')
                                 <input type="submit" class="deletecomment" value="{{__('message.Delete')}}">
                              </form>
                              </p>
                           </div>
                        </div>
                     </div>
                     @endforeach
                  </div>
                  <div class="comment-form">
                     <h4>{{__('message.Leave_a_comment')}}</h4>
                     <form action="{{url('comment')}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="reviewid" value="{{ $review->id }}">
                        <input type="hidden" name="bookid" value="{{ $book->id }}">
                        <div class="row">
                           <div class="col-md-12">
                              <textarea name="body" id="" placeholder="{{__('message.Comments')}}"></textarea>
                           </div>
                        </div>
                        <input class="submit" type="submit" value="{{__('message.save')}}">
                     </form>
                  </div>
                  <!-- comment form -->
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection