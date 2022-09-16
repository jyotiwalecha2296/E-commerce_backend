<ul>
@foreach($childs as $child)
   <li class="row1">
       {{ $child->title }}
   @if(count($child->childs))
            @include('admin.menu.manageChild',['childs' => $child->childs])
        @endif
   </li>
@endforeach
</ul>