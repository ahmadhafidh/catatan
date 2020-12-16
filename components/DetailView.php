<?php
namespace app\components;

class DetailView
{

    public static function widget(Array $config)
    {
        $data = $config;
        $attr = self::normalize($data['attributes']);
        // dd($attr);
        foreach ($attr as $key => $value) {
            $group = str_replace('_', ' ', $key);
            $group = ucwords($group);
            $arr[] = '<div  class="dv-group"><br> <p class="dv-title"><b>'.$group.'</b></p><br> ';
            $arr[] = self::initItem($value, $data['model']);
            $arr[] = '</div>';
        }
        // dd($arr);
        return "<div class='detail-view'>". implode(' ', $arr)."</div>";
    }

    public static function modal(Array $config)
    {
        $data = $config;
        $attr = $data['attributes'];
        // dd($attr);
        foreach ($attr as $key => $value) {
            $req = json_decode($data['model']->$value); 
            $reqData = (json_last_error() > 0 && $data['model']->$value !== null) ? $data['model']->$value : json_encode($req, JSON_PRETTY_PRINT);
            $title = str_replace('_', ' ', $value);
            $title = ucwords($title);
            $arr[] = '<div class="col-md-12">
            <div class="dv-group">
                <div class="table-align mb-3">
                    <h6 class="dv-title-bold ta-text"><b>'.$title.'</b></h6> 
                    <div class="h-spacer"></div> <a href="javascript:void(0)" onclick="copyContent(this, 
                    \'output_'.$value.'\')" class="btn btn-light btn-outline btn-sm">Copy</a>
                </div>
                <div class="output json" id="output_'.$value.'"><pre><code>';
            $arr[] = $reqData.'</code></pre>';
            $arr[] = '</div>
                        </div>        
                    </div>';
        }
                
        // dd($arr);
        return implode(' ', $arr);
    }

    public static function initItem($attr, $model)
    {
        foreach ($attr as $key => $value) {
            $mkey = $value['key'];
            $bb = explode('+', $mkey);
            if (count($bb)>1) {
                $mkey = $bb[0];
                $mkey2 = $bb[1];
                $model2 = $value['label'];
                if (isset($model->$model2)) {
                    $data = [$model->$mkey, $model->$model2->$mkey2];
                } else {
                    $data = $model->$mkey;
                }
            }
            else{
                $data = $model->$mkey;
            }
            $type = isset($value['type']) ? $value['type'] : null;
            $newArr[] = self::createItem($value['label'], $data, $type,$value['false_label']);
        }
        return implode(' ', $newArr);
    }
    public static function createItem( $title,  $content, $type=null, $false_label=null)
    {
        $title = str_replace('_', ' ', $title);
        if (is_array($content)) {
            $content = $content[0].' - '.$content[1];
        }
        $title = ucwords($title);
        if ($type=='yesorno') {
            $title = $content=='yes' ? "<span style='color:green'>".$title.
            "</span>" : "<span style='color:red'>".$false_label."</span>";
        }
        if ($type=='boolean') {
            $title = $content ? "<span style='color:green'>".$title.
            "</span>" : "<span style='color:red'>".$false_label."</span>";
        }
        

        $content = $content=='' ? '(not set)' : $content;
        $content = ($type!=null) ? self::format($content, $type, $title) : $content;
        $widget = '<p><small>'.$title.'</small><br><b>
        '.$content.'</b></p>';
        return $widget;
    }
    public static function format($str, $type, $label=null)
    {
        switch ($type) {
            case 'email':
                $new = '<a href="mailto:'.$str.'">'.$str.'</a>';
                break;
            case 'date':
                $new = date('l, d/m/Y', strtotime($str));
                break;
            case 'money':
                $new = "Rp ".number_format((int)$str, 0, '.', ',');
                break;
            case 'boolean':
                $new = null;
                break;
            case 'yesorno':
                $new = null;
                break;
            case 'json':
                $new = '<div class="output" id="output"><pre><code>'.$str.'</code></pre></div>';
                break;
            
            default:
                $new = $str;
                break;
        }
        return $new;
    }
    public static function getType($arr)
    {
        if (!is_array($arr)) {
            $arr_tmp = explode(':', $arr);
            return ['label' => $arr_tmp[0],
            'type' => isset($arr_tmp[1]) ? $arr_tmp[1] : null];
        }
        foreach ($arr as $key => $value) {
            $arr_tmp = explode(':', $value);
            $new[] = [
                'key' => $arr_tmp[0],
                'type' => isset($arr_tmp[2]) ? $arr_tmp[2] : null,
                'label' => isset($arr_tmp[1]) ? $arr_tmp[1] : $arr_tmp[0],
                'false_label' => isset($arr_tmp[3]) ? $arr_tmp[3] : $arr_tmp[0],
            ];
        }
        return $new;
    }
    public static function normalize($data)
    {
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $arr[] = $value;
            }
            $group = isset($value['group']) ? $value['group'] : null;
            $value = is_array($value) ? $value['items'] : $value;
            $value = self::getType($value);
            $newArr[$group] = $value;
            
        }
        if (isset($arr)) {
            $arr = self::getType($arr);
            $newArr[null] = $arr;
        }
        return $newArr;
    }
    
}
