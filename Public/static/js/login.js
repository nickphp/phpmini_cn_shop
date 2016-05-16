 $(document).ready(function(){ 
    var login = {};
    login.rsaN = "A563EA84490CCA293E32DB18CD2E5ED6B6EB5ED2035177DE392DA5E0EB70BB6AB02270B9B9E8BB553BA4E0CB6DC28FACCC697AEC4B9A6E74A707A0E40642CA7F675642F0048F3E51D43381259E8624AE457BA89DD0D289B2F251EAC52C4A7118EA262D5FFC53275B0276AAF8F4040FB9376D95D73CADF3EE191C67FDD653DCCD";  
    login.OValidationCode = $("#validationCode");
    login.OValidationCode.bind("click",function(){
        $(this).attr("src","/index/loginVCode?r="+Math.random());
    })
    $("#loginForm").submit(function() {
        login.OLoginName = $("#loginname");
        login.OPassWord  = $("#password");
        login.OWarning = $("#warning");
        login.OVcode = $("#vcode");
        login.OJpass = $("#jpass");
        login.loginName  = login.OLoginName.val(); 
        login.loginPass  = login.OPassWord.val();
        login.loginVcode = login.OVcode.val();
        login.isEmpty = function(value) {
            if (value == '' || value == undefined 
                            || value == null 
                            || value === '0') {
                return true;
            } 
            return false;
        }
        login.isChn = function (str){
            var reg = /[\u4E00-\u9FA5]/;
            if(reg.test(str)){ return true;}
            return false;
        }
        login.isVcode = function(str) {
            var reg = /[a-zA-Z0-9]{4}/;
            if(!reg.test(str)){ return true;}
            return false;
        }
        login.getMsg = function(msg) {
            var msg = '<div class="alert alert-warning alert-dismissible" role="alert">'
                    + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                    + '<strong>错误！</strong>'
                    + msg 
                    + '</div>';
            return msg;
        }
        if (login.isEmpty(login.loginName)) { 
            login.OWarning.html(login.getMsg("用户名必须填写！"));
            return false; 
        }
        if (login.isEmpty(login.loginPass)) { 
            login.OWarning.html(login.getMsg("密码必须填写！"));
            return false;
        }
        if (login.isChn(login.loginPass)) { 
            login.OWarning.html(login.getMsg("密码不能包含中文字符！"));
            return false;
        }
        if(login.OVcode.attr("isOn") == "1") {
            if (login.isEmpty(login.loginVcode)) { 
                login.OWarning.html(login.getMsg("验证码必须填写！"));
                return false;
            }
            if (login.isChn(login.loginVcode)) { 
                login.OWarning.html(login.getMsg("验证码不能包含中文字符！"));
                return false;
            }
            if (login.isVcode(login.loginVcode)) { 
                login.OWarning.html(login.getMsg("验证码必须是图片上的4位字符串！"));
                return false;
            }
        }
        login.OWarning.hide(300);
        setMaxDigits(131);
        login.key      = new RSAKeyPair("10001", '', login.rsaN);  
        login.encodePassword = encryptedString(login.key, login.loginPass);
        login.OPassWord.val(login.encodePassword);
        
    });
});  