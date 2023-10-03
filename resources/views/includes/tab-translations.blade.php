@if(isset($fields) && count($fields))
    <!-- Nav tabs -->
    <ul class="nav nav-tabs col-12" role="tablist">
        @foreach(getAllLanguages() as $key => $lang)
            <li class="nav-item">
                <a class="nav-link @if($loop->first) active @endif" onclick="chose_tap($(this))" data-toggle="tab"
                   data-href=".nav-form-{{$lang->id}}"
                   role="tab">

                    <img class="mx-1" src="{{ asset('assets/images/flags/' . $lang->code . '.png')}}"/> {{$lang->name}}
                </a>
            </li>
        @endforeach

    </ul>


    <!-- Tab panes -->
    <div class="tab-content col-12">
        @foreach(getAllLanguages() as $key => $lang)
            <div class="tab-pane nav-form-{{$lang->id}} @if($loop->first) active @endif" id="" role="tabpanel">

                @foreach($fields as $field)
                    @if(isset($field['type'])&&$field['type']=='area')


                        <div class="form-group col-sm-12 col-lg-12 ">
                            {!! Form::label("{$lang->key}[{$field['model_key']}]", $field['model_name'].'( '.$lang->name.')',['class'=>isset($field['class_label']) ?$field['class_label']:'col-form-label  col-12 col-md-3 col-lg-3']) !!}
                            <div class="col-sm-12 col-md-12">
                                {!! Form::textarea($lang->key."[{$field['model_key']}]", (isset($field['model'])?$field['model']->getTranslationOrNew($lang->key)->{$field['model_key']}:null),
     ['class' => 'form-control' . ($errors->has("{$lang->key}[{$field['model_key']}]")?' is-invalid':'') ,"id"=>$lang->key."."."{$field['model_key']}",'rows'=>5 ]) !!}
                                @if ($errors->has("{$lang->key}[{$field['model_key']}]"))
                                    <span class="invalid-feedback">
                                                     <small
                                                         class="text-danger">{{ $errors->first("{$lang->key}[{$field['model_key']}]") }}</small>

                                               </span>
                                @endif
                            </div>
                        </div>



                        @else
                        <?php
                        $onkey="";
                        if(isset($field['onkey'])){
                            $onkey=
                                [
                                    "onkeyup"=>
                                $field['onkey'].'($(this),"'.$lang["key"].'")'
                                    ];

}


                        ?>

                    <div class="form-group col-sm-12 col-lg-12 mb-3">
                        {!! Form::label("{$lang->key}[{$field['model_key']}]", $field['model_name'].'( '.$lang->name.')',
[  'class'=> isset($field['class_label']) ?$field['class_label']:'col-form-label  col-12']) !!}
                        <div class="col-sm-12 col-md-12">
                            {!! Form::text($lang->key."[{$field['model_key']}]", (isset($field['model'])?$field['model']->getTranslationOrNew($lang->key)->{$field['model_key']}:null),
 ["onkeyup"=> $onkey['onkeyup']??"" ,'class' => 'form-control' . ($errors->has("{$lang->key}[{$field['model_key']}]")?' is-invalid':'') ,"id"=>$lang->key."."."{$field['model_key']}",'minlength' =>1,'maxlength' => 255 ]) !!}
                            @if ($errors->has("{$lang->key}[{$field['model_key']}]"))
                                <span class="invalid-feedback">
                                                     <small
                                                         class="text-danger">{{ $errors->first("{$lang->key}[{$field['model_key']}]") }}</small>

                                               </span>
                            @endif
                        </div>
                    </div>
                    @endif

                @endforeach
            </div>
        @endforeach

    </div>
@endif
