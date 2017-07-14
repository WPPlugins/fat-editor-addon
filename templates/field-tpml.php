<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 5/17/2017
 * Time: 10:11 AM
 */
?>
<!-- text field -->
<script type="text/html" id="tmpl-fat-text-field">
    <div class="fat-cmb-text-wrap fat-cmb-field-wrap" {{{data.depend_field}}}>
        <label for="{{{data.field_id}}}">{{{data.field_label}}}</label>
        <div class="fat-cmb-field">
            <input type="text" name="{{{data.field_name}}}" value="{{{data.field_value}}}"
                   data-field-name="{{{data.field_name}}}" data-field-type="text"
                   id="{{{data.field_id}}}"
                   data-std="{{{data.field_std}}}" />
            <span class="fat-cmb-description">{{{data.field_description}}}</span>
        </div>
    </div>
</script>
<!-- number field -->
<script type="text/html" id="tmpl-fat-number-field">
    <div class="fat-cmb-text-wrap fat-cmb-field-wrap" {{{data.depend_field}}}>
        <label for="{{{data.field_id}}}">{{{data.field_label}}}</label>
        <div class="fat-cmb-field">
            <input type="number" name="{{{data.field_name}}}" value="{{{data.field_value}}}"
                   {{{data.field_max}}} {{{data.field_min}}} {{{data.field_step}}}
                   data-field-name="{{{data.field_name}}}" data-field-type="text"
                   id="{{{data.field_id}}}"
                   data-std="{{{data.field_std}}}" />

            <span class="fat-cmb-description">{{{data.field_description}}}</span>
        </div>
    </div>
</script>
<!-- checkbox field -->
<script type="text/html" id="tmpl-fat-checkbox-field">
    <div class="fat-cmb-check-wrap fat-cmb-field-wrap" {{{data.depend_field}}}>
        <label for="{{{data.field_id}}}"> {{{data.field_label}}} </label>
        <div class="fat-cmb-field">
            <ul name="{{{data.field_name}}}" id="{{{data.field_id}}}" class="fat-radio-group "
                data-field-name="{{{data.field_name}}}" data-field-type="checkbox">
                <# var index = 0,
                    checked = '';
                    _.each( data.field_options, function(opt_value, opt_key) {
                    checked = '';
                    if(opt_key === data.field_value){
                    checked = 'checked';
                    }
                    #>
                    <li>
                        <input type="checkbox" value="{{opt_key}}" id="{{data.field_id}}_{{index}}"
                               name="{{{data.field_name}}}" {{checked}}>
                        {{opt_value}}
                    </li>
                    <# index++; }) #>
            </ul>
            <span class="fat-cmb-description">{{{data.field_description}}}</span>
        </div>
    </div>
</script>
<!-- select field -->
<script type="text/html" id="tmpl-fat-select-field">
    <div class="fat-cmb-select-wrap fat-cmb-field-wrap" {{{data.depend_field}}}>
        <label for="{{{data.field_id}}}"> {{{data.field_label}}} </label>
        <div class="fat-cmb-field">
            <# var multiple = '';
                if(data.field_multiple !='null' && data.field_multiple=='1'){
                multiple = 'multiple';
                }
                #>
                <select class="fat-cmb-select" name="{{{data.field_name}}}" id="{{{data.field_id}}}"
                        {{{multiple}}} data-field-name="{{{data.field_name}}}" data-field-type="select"
                        data-selected="{{{data.field_value}}}">
                    <# _.each( data.field_options, function(opt_value, opt_key) { #>
                        <option value="{{opt_key}}">{{opt_value}}</option>
                        <# }) #>
                </select>
                <span class="fat-cmb-description">{{{data.field_description}}}</span>
        </div>

    </div>
</script>
<!-- color field -->
<script type="text/html" id="tmpl-fat-color-field">
    <div class="fat-cmb-color-wrap fat-cmb-field-wrap" {{{data.depend_field}}}>
        <label for="{{{data.field_id}}}"> {{{data.field_label}}}</label>
        <div class="fat-cmb-field">
            <input type="text" name="{{{data.field_name}}}" id="{{{data.field_id}}}"
                   data-field-name="{{{data.field_name}}}" data-field-type="color"
                   data-alpha="true"
                   value="{{{data.field_value}}}"
                   data-std="{{{data.field_std}}}"
                   class="fat-cmb-color-picker" />
            <span class="input-group-addon"><i></i></span>

            <span class="fat-cmb-description">{{{data.field_description}}}</span>
        </div>
    </div>
</script>
<!-- radio button -->
<script type="text/html" id="tmpl-fat-radio-field">
    <div class="fat-cmb-radio-wrap fat-cmb-field-wrap" {{{data.depend_field}}}>
        <label for="{{{data.field_id}}}"> {{{data.field_label}}}</label>
        <div class="fat-cmb-field">
            <ul name="{{{data.field_name}}}" id="{{{data.field_id}}}" class="fat-radio-group "
                data-field-name="{{{data.field_name}}}" data-field-type="radio">
                <# var index = 0,
                    checked = '';
                    _.each( data.field_options, function(opt_value, opt_key) {
                    checked = '';
                    if(opt_key === data.field_value){
                    checked = 'checked';
                    }
                    #>
                    <li>
                        <input type="radio" value="{{opt_key}}" id="{{data.field_id}}_{{index}}"
                               name="{{{data.field_name}}}" {{checked}}>
                        {{opt_value}}
                    </li>
                    <# index++; }) #>
            </ul>
            <span class="fat-cmb-description">{{{data.field_description}}}</span>
        </div>
    </div>
</script>

<!-- single image -->
<script type="text/html" id="tmpl-fat-single-image-field">
    <div class="fat-cmb-images-wrap fat-cmb-field-wrap" {{{data.depend_field}}}>
        <label for="{{{data.field_id}}}"> {{{data.field_label}}}</label>
        <div class="fat-add-single-image-wrap fat-cmb-field">
            <input type="hidden" value="{{data.field_value}}" name="{{{data.field_name}}}" id="{{{data.field_id}}}" data-field-name="{{{data.field_name}}}" data-field-type="single_image" />
            <div class="fat-list-image" data-input-id="{{{data.field_id}}}">

            </div>
            <a href="javascript:;" class="fat-add-single-image"
               data-input-id="{{{data.field_id}}}">Choice image</a>
        </div>
        <span class="fat-cmb-description">{{{data.field_description}}}</span>
    </div>
</script>
<script type="text/html" id="tmpl-fat-single-image-item">
    <div class="fat-image-thumb" data-id="{{{data.image_id}}}">
        <img src="{{{data.image_url}}}" />
        <div class="fat-overlay fat-transition-30">
            <span>
                <a class="fat-delete-single-image" data-id="{{{data.image_id}}}"
                   href="javascript:;"><i
                        class="dashicons dashicons-no-alt"></i></a>
            </span>
        </div>
    </div>
</script>