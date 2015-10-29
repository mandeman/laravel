@extends('layouts.ucenter')

@section('content')
<div class="common-info clearfix">
    <h4 class="content-title">我的账户</h4>
    <ul class="content-nav clearfix">
        <li ><a href="/account">基本信息</a></li>
        <li ><a href="/account/messages">我的消息(0)</a></li>
        <li ><a href="/account/banks">我的银行卡</a></li>
        <li class="current"><a href="javascript:void(0)">资料修改</a></li>
        <li ><a href="#">奖金详情</a></li>
    </ul>
</div>
<div class="table-area">
    <form name="form3" id="form3">
        <h4 class="ui-form-title mt20">
                修改<span style=" color:#ea6b6c; font-weight:bold">昵称</span>
            </h4>
        <div class="ui-content mt20">
            <div>
                <span class="ui-title inline">新昵称：</span>
                <input type="text" id="nickname" name="nickname" class="ui-input input" autocomplete="off" value="">
                <span class="ml20">
                    <em class="color-red"></em>
                </span>
            </div>
            <div class="mt10">
                <span class="ui-title inline"></span>
                <button class="ui-btn edit-button important-thumb btn-important" type="button"  onclick="submitNick()"><i class="icon-ok white mr5"></i>修改</button>
            </div>
            
        </div>
    </form>
    <form method="" action="#" name="form1" id="form1">
        <h4 class="ui-form-title mt20">
                修改<span style=" color:#ea6b6c; font-weight:bold">登陆</span>密码
            </h4>
        <div class="ui-content mt20">
            <div>
                <span class="ui-title inline">旧登陆密码：</span>
                <input type="password" id="old_pass" name="old_pass" class="ui-input input" autocomplete="off">
                <span class="ml20">
                        <em class="color-red"></em>
                    </span>
            </div>
            <div class="mt15">
                <span class="ui-title inline">新登陆密码：</span>
                <input type="password" id="new_pass" name="new_pass" class="ui-input input">
                <span class="ml20">
                        不能和资金密码一样
                    </span>
            </div>
            <div class="mt15">
                <span class="ui-title inline">确认登陆密码：</span>
                <input type="password" id="two_new_pass" name="two_new_pass" class="ui-input input">
            </div>
            <div class="mt10">
                <span class="ui-title inline"></span>
                <button class="ui-btn important-thumb btn-important" type="button" onclick="submitPasswd()"><i class="icon-ok white mr5"></i>修改</button>
            </div>
        </div>
    </form>
    <form action="#" name="form2" id="form2">
        <h4 class="ui-form-title mt20">
                修改<span style=" color:#ea6b6c; font-weight:bold">资金</span>密码
            </h4>
        <div class="ui-content mt20">
            <div>
                <span class="ui-title inline">旧资金密码：</span>
                <input type="password" name="old_bank" id="old_bank" class="ui-input input" autocomplete="off">
                <span class="ml20"><em class="color-red"></em></span>
            </div>
            <div class="mt15">
                <span class="ui-title inline">新资金密码：</span>
                <input type="password" name="new_bank" id="new_bank" class="ui-input input">
                <span class="ml20">
                        不能和登录密码一样
                    </span>
            </div>
            <div class="mt15">
                <span class="ui-title inline">确认资金密码：</span>
                <input type="password" name="two_new_bank" id="two_new_bank" class="ui-input input">
            </div>
            <div class="mt10">
                <span class="ui-title inline"></span>
                <button class="ui-btn important-thumb btn-important" type="button" onclick="submitCoinPasswd()"><i class="icon-ok white mr5"></i>修改</button>
            </div>
        </div>
    </form>
</div>

@stop

@section('scripts')
<script>
var toastr = window.parent.toastr;

function submitNick(){
    var action = "&action=nickname";
    if ($('#nickname').val() == '') {
        return toastr.warning('昵称不能不能为空');
    }
    window.parent.swal({
        title: "确定修改昵称么?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#5cb85c',
        confirmButtonText: '确定',
        closeOnConfirm: false,
        cancelButtonText: "取消",
        //closeOnCancel: false
    },
    function(){
        R('/account/update', {
            method: "post",
            data: $('#form3').serialize()+'&_token=' +$('#_token').val() + action,
            ok:function(){
                window.parent.location.reload();
            }
        });
    });
}




</script>
@stop

