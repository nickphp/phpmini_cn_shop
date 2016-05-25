(function(window){
    $(function(){
        var tableInfo = {};//表格对象
            tableInfo.currentActiveId = "";//当前活动元素
        $(".table-row").bind("click",function(){
           $(".table-row").removeClass("active_on table-line-bg");
           $(".table-row").find("input[name='active_radio']").prop("checked", false);
           $(this).addClass("active_on table-line-bg");
           $(this).find("input[name='active_radio']").prop("checked", true);
           tableInfo.currentActiveId = $(this).data("id");
        }); 
        var operator = {};
        operator.execOperator = function(_this) {
            if(!tableInfo.currentActiveId) {
                var d = dialog({
                    width:"200",
                    title: '提醒',
                    content: '未选中任何行，请选择后再操作'
                });
                d.showModal();
                return false;
            }
            var currentOperatorName = $(_this).data("opername");
            if(!currentOperatorName) {
                return false;
            }
            operator[currentOperatorName]();
        }
        operator.copy = function() {
        };
        operator.add = function() {
            console.log(tableInfo.currentActiveId);
        };
        operator.edit = function() {
            console.log(tableInfo.currentActiveId);
        };
        operator.look = function() {
            console.log(tableInfo.currentActiveId);
        };
        operator.search = function() {
            console.log(tableInfo.currentActiveId);
        };
        operator.audit = function() {
            var d = dialog({
                title:"订单审核",
                content:'<textarea class="form-control audit_remark" rows="3"></textarea>',
                okValue: "确定",
                ok:function () {
                    var remark = $(".audit_remark").val();
                    if(!remark) {
                        dialog({"title":"提醒","content":"请填写备注","width":"100"}).showModal();
                        return false;
                    }
                    $.ajax({
                       url:"/index/test",
                       dataType:"json",
                       type:"post",
                       data:{"remark":remark},
                       success:function(data)
                       {
                           var tmp = $(".active_on").find("td").eq(1).text();
                           $(".active_on").find("td").eq(1).html(tmp + ' ' + '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>');
                           dialog({"title":"响应消息","content":data.remark,"width":"100"}).showModal();
                       }
                    });
                }
            }).showModal();
        };
        operator.cancle = function() {
            console.log(tableInfo.currentActiveId);
        };
        operator.remove = function() {
            console.log(tableInfo.currentActiveId);
        };
        $(".operator-button").bind("click",function(){
            operator.execOperator(this);
        });
        
        
        $(".import_auth").bind("click",function(){
            var PostData = {};
            PostData.auth_action = $(this).parents(".table-row").find("td").eq(0).text();
            PostData.controller_name = $(this).parents(".table-row").find("td").eq(1).text();
            PostData.space_name = $(this).parents(".table-row").find("td").eq(2).text();
            var _this = this;
            $.ajax({
                url:"/Home/Index/addAuthPost",
                dataType:"json",
                type:"post",
                data:PostData,
                success:function(data)
                {
                    if (data.status == 1) {
                        
                        var html = '<span style="color:#434343;">'+
                        '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'+
                        '</span>';
                        
                        $(_this).parents(".table-row").find("td").eq(3).html(html);
                        $(_this).parents(".table-row").attr("data-auth_create","1");
                        $(_this).hide();
                        $(_this).parent().find(".remove_auth").show();
                    } else {
                         dialog({"title":"操作提醒！","content":data.message,"width":"200"}).showModal();
                    }
                },
                error:function(){
                    dialog({"title":"操作提醒！","content":"接口通信异常","width":"200"}).showModal();
                }
            });
        });
        
        $(".remove_auth").bind("click",function(){            
            var PostData = {};
            PostData.auth_action = $(this).parents(".table-row").find("td").eq(0).text();
            PostData.controller_name = $(this).parents(".table-row").find("td").eq(1).text();
            PostData.space_name = $(this).parents(".table-row").find("td").eq(2).text();
            var _this = this;
            $.ajax({
                url:"/Home/Index/removeAuthPost",
                dataType:"json",
                type:"post",
                data:PostData,
                success:function(data)
                {
                    if (data.status == 1) {
                         var html = '<span style="color:#ED0000;">'+
                        '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'+
                        '</span>';
                        $(_this).parents(".table-row").find("td").eq(3).html(html);
                        $(_this).parents(".table-row").attr("data-auth_create","0");
                        $(_this).hide();
                        $(_this).parent().find(".import_auth").show();
                    } else {
                         dialog({"title":"操作提醒！","content":data.message,"width":"200"}).showModal();
                    }
                },
                error:function(){
                    dialog({"title":"操作提醒！","content":"接口通信异常","width":"200"}).showModal();
                }
            });
        });  
        
        $(".import_all_auth").bind("click",function(){
            var PostData = {};
                PostData.data = [];
            var i = 0;
            $(".table-row").each(function(index,el){
                var auth_create = $(el).attr('data-auth_create');
                if (auth_create == 0) {
                    var tmpData = {}; 
                    tmpData.action_name = $(el).find("td").eq("0").text();
                    tmpData.controller_name = $(el).find("td").eq("1").text();
                    tmpData.space_name = $(el).find("td").eq("2").text();
                    PostData.data[i] = tmpData;
                    i++;
                }
            });
            if (PostData.data.length == 0) {
                dialog({"title":"操作提醒！","content":"没有权限需要导入","width":"200"}).showModal();
                return false;
            }
            $.ajax({
                url:"/Home/Index/addAllAuthPost",
                dataType:"json",
                type:"post",
                data:PostData,
                success:function(data)
                {
                    if (data.status == 1) {
                        $(".table-row").each(function(index,el){
                            var html = '<span style="color:#434343;">'+
                            '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'+
                            '</span>';
                            $(el).attr('data-auth_create',"1");
                            $(el).find("td").eq(3).html(html);
                            $(el).find(".import_auth").hide();
                            $(el).find(".remove_auth").show();
                        });
                        dialog({"title":"操作提醒！","content":data.message,"width":"200"}).showModal();
                    } else {
                        dialog({"title":"操作提醒！","content":data.message,"width":"200"}).showModal();
                    }
                },
                error:function(){
                    dialog({"title":"操作提醒！","content":"接口通信异常","width":"200"}).showModal();
                }
            });
        });
        
        //删除所有权限
        $(".remove_all_auth").bind("click",function(){
            var PostData = {};
                PostData.data = [];
            var i = 0;
            $(".table-row").each(function(index,el){
                var auth_create = $(el).attr('data-auth_create');
                if (auth_create == '1') {
                    var tmpData = {}; 
                    tmpData.action_name = $(el).find("td").eq("0").text();
                    tmpData.controller_name = $(el).find("td").eq("1").text();
                    tmpData.space_name = $(el).find("td").eq("2").text();
                    PostData.data[i] = tmpData;
                    i++;
                }
            });
            
            if (PostData.data.length == 0) {
                dialog({"title":"操作提醒！","content":"没有权限需要删除","width":"200"}).showModal();
                return false;
            }

            $.ajax({
                url:"/Home/Index/removeAllAuthPost",
                dataType:"json",
                type:"post",
                data:PostData,
                success:function(data)
                {
                    if (data.status == 1) {
                        $(".table-row").each(function(index,el){
                            var html = '<span style="color:#ED0000;">'+
                            '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'+
                            '</span>';
                            $(el).find("td").eq(3).html(html);
                            $(el).find(".remove_auth").hide();
                            $(el).find(".import_auth").show();
                            $(el).attr('data-auth_create',"0");
                        });
                        dialog({"title":"操作提醒！","content":data.message,"width":"200"}).showModal();
                    } else {
                        dialog({"title":"操作提醒！","content":data.message,"width":"200"}).showModal();
                    }
                },
                error:function(){
                    dialog({"title":"操作提醒！","content":"接口通信异常","width":"200"}).showModal();
                }
            });
        });
        
    });
})(window);
