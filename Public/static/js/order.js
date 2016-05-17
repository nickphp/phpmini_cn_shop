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
            dialog({
                title:"订单审核",
                content:'<textarea name="audit_remark" class="audit_remark"></textarea>',
                button: [
                    {
                        value: '审核通过',
                        callback: function () {
                            if(!$(".audit_remark").val()) {
                                dialog({"content":"请填写备注","id":"12343","title":"提醒"}).showModal();
                                return false;
                            }
                        this.content('审核通过成功');
                            return false;
                        },
                        autofocus: false
                    },
                    {
                        value: '审核拒绝',
                        callback: function () {
                            this.content('审核拒绝成功');
                            return  false;
                        },
                        autofocus: false
                    }
                ]
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
    });
})(window);
