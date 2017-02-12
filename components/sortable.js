$(document).ready(function (){
	$("[data-sortable]").sortable({
	    items: '[data-order]',
	    update: function (ev, ui){
		var subj = ui.item.parent();
		var sortable_new_order = { subj:subj.attr("data-sortable"), order:[]};
		subj.children("[data-order]").each(function (i, e){
		    sortable_new_order.order.push($(e).attr("data-order"))
		});
		$.post("?ajax", {sortable_new_order : sortable_new_order });
	    }
	});
});