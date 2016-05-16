 $(document).ready(function(){ 
    var register = {};
    register.rsaN = "A563EA84490CCA293E32DB18CD2E5ED6B6EB5ED2035177DE392DA5E0EB70BB6AB02270B9B9E8BB553BA4E0CB6DC28FACCC697AEC4B9A6E74A707A0E40642CA7F675642F0048F3E51D43381259E8624AE457BA89DD0D289B2F251EAC52C4A7118EA262D5FFC53275B0276AAF8F4040FB9376D95D73CADF3EE191C67FDD653DCCD";  
    register.OValidationCode = $("#registerVCode");
    register.OReadme = $("#readme");
    register.OValidationCode.bind("click",function(){
        $(this).attr("src","/index/registerVCode?r="+Math.random());
    });
    register.OReadme.bind("click",function(){
        var sval = $(this).attr("isSelect");
        if (sval === undefined || sval == "1") {
            $(this).attr("isSelect","2");
        } else {
            $(this).attr("isSelect","1");
        }
    });
    $("#registerForm").submit(function() {
        register.OLoginName = $("#registername");
        register.OPassWord  = $("#password");
        register.OConfirmPass  = $("#confirmpass");
        register.OWarning = $("#warning");
        register.OVcode = $("#vcode");
        register.registerName  = register.OLoginName.val(); 
        register.registerPass  = register.OPassWord.val();
        register.registerConfirmPass = register.OConfirmPass.val();
        register.registerVcode = register.OVcode.val();
        register.registerReadme = register.OReadme.attr("isSelect");
        register.isEmpty = function(value) {
            if (value == '' || value == undefined 
                            || value == null 
                            || value === '0') {
                return true;
            } 
            return false;
        }
        register.isChn = function (str){
            var reg = /[\u4E00-\u9FA5]/;
            if(reg.test(str)){ return true;}
            return false;
        }
        register.isVcode = function(str) {
            var reg = /[a-zA-Z0-9]{4}/;
            if(!reg.test(str)){ return true;}
            return false;
        }
        register.getMsg = function(msg) {
            var msg = '<div class="alert alert-warning alert-dismissible" role="alert">'
                    + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                    + '<strong>错误！</strong>'
                    + msg 
                    + '</div>';
            return msg;
        }
        if (register.isEmpty(register.registerName)) { 
            register.OWarning.html(register.getMsg("用户名必须填写！"));
            return false; 
        }
        if (register.isEmpty(register.registerPass)) { 
            register.OWarning.html(register.getMsg("密码必须填写！"));
            return false;
        }
        if (register.isChn(register.registerPass)) { 
            register.OWarning.html(register.getMsg("密码不能包含中文字符！"));
            return false;
        }
         if (register.isEmpty(register.registerConfirmPass)) { 
            register.OWarning.html(register.getMsg("确认密码必须填写！"));
            return false;
        }
        if (register.isChn(register.registerConfirmPass)) { 
            register.OWarning.html(register.getMsg("确认密码不能包含中文字符！"));
            return false;
        }
        if (register.registerConfirmPass !== register.registerPass) { 
            register.OWarning.html(register.getMsg("两次密码输入不一致！"));
            return false;
        }
        if(register.OVcode.attr("isOn") == "1") {
            if (register.isEmpty(register.registerVcode)) { 
                register.OWarning.html(register.getMsg("验证码必须填写！"));
                return false;
            }
            if (register.isChn(register.registerVcode)) { 
                register.OWarning.html(register.getMsg("验证码不能包含中文字符！"));
                return false;
            }
            if (register.isVcode(register.registerVcode)) { 
                register.OWarning.html(register.getMsg("验证码必须是图片上的4位字符串！"));
                return false;
            }
        }
        if (register.registerReadme == "1" || register.registerReadme === undefined) {
            register.OWarning.html(register.getMsg("请阅读注册条款！"));
            return false;
        }
        register.OWarning.hide(300);
        setMaxDigits(131);
        register.key      = new RSAKeyPair("10001", '', register.rsaN);
        register.encodePassword = encryptedString(register.key, register.registerPass);
        register.encodeConfirmPassword = encryptedString(register.key, register.registerConfirmPass);
        register.OPassWord.val(register.encodePassword);
        register.OConfirmPass.val(register.encodeConfirmPassword);
    });
});  