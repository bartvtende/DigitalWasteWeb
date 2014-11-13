@extends('layout.master')

@section('scripts')
{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js') }}
<script>
var __slice=[].slice;(function(e,t){var n;n=function(){function t(t,n){var r,i,s,o=this;this.options=e.extend({},this.defaults,n);this.$el=t;s=this.defaults;for(r in s){i=s[r];if(this.$el.data(r)!=null){this.options[r]=this.$el.data(r)}}this.createStars();this.syncRating();this.$el.on("mouseover.starrr","span",function(e){return o.syncRating(o.$el.find("span").index(e.currentTarget)+1)});this.$el.on("mouseout.starrr",function(){return o.syncRating()});this.$el.on("click.starrr","span",function(e){return o.setRating(o.$el.find("span").index(e.currentTarget)+1)});this.$el.on("starrr:change",this.options.change)}t.prototype.defaults={rating:void 0,numStars:5,change:function(e,t){}};t.prototype.createStars=function(){var e,t,n;n=[];for(e=1,t=this.options.numStars;1<=t?e<=t:e>=t;1<=t?e++:e--){n.push(this.$el.append("<span class='fa fa-star-o'></span>"))}return n};t.prototype.setRating=function(e){if(this.options.rating===e){e=void 0}this.options.rating=e;this.syncRating();return this.$el.trigger("starrr:change",e)};t.prototype.syncRating=function(e){var t,n,r,i;e||(e=this.options.rating);if(e){for(t=n=0,i=e-1;0<=i?n<=i:n>=i;t=0<=i?++n:--n){this.$el.find("span").eq(t).removeClass("fa fa-star-o").addClass("fa fa-star")}}if(e&&e<5){for(t=r=e;e<=4?r<=4:r>=4;t=e<=4?++r:--r){this.$el.find("span").eq(t).removeClass("fa fa-star").addClass("fa fa-star-o")}}if(!e){return this.$el.find("span").removeClass("fa fa-star").addClass("fa fa-star-o")}};return t}();return e.fn.extend({starrr:function(){var t,r;r=arguments[0],t=2<=arguments.length?__slice.call(arguments,1):[];return this.each(function(){var i;i=e(this).data("star-rating");if(!i){e(this).data("star-rating",i=new n(e(this),r))}if(typeof r==="string"){return i[r].apply(i,t)}})}})})(window.jQuery,window);$(function(){return $(".starrr").starrr()})

$(function(){
  var ratingsField = $('#ratings-hidden');

  $('.starrr').on('starrr:change', function(e, value){
    ratingsField.val(value);
  });
});
</script>
@stop

@section('content')
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Item {{ $data->id }}</h3>
		</div>

		<div class="panel-body"> 
			Path: {{ $data->path }}

			{{ HTML::image('http://placehold.it/1024x600', null, ['class' => 'img-responsive img-rounded']) }}

			@if(Session::get('message'))
			<div class="alert alert-dismissable alert-info">
			  <button type="button" class="close" data-dismiss="alert">×</button>
			  <p>{{ Session::get('message') }}</p>
			</div>
			@endif

			<form action="{{ URL::route('rateData') }}" method="post">
				<div class="stars starrr" data-rating="0"></div>

                <input type="hidden" name="rating" id="ratings-hidden"> 
				<input type="hidden" name="id" value="{{ $data->id }}">
				<input type="hidden" name="selectedId" value="{{ $selectedData->id }}">

				<button class="btn btn-primary" type="submit">Beoordeel!</button>
			</form>
		</div>
	</div>
</div>
@stop