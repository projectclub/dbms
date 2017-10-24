			var sorterfn ={
				by_id:function(a,b){
					return parseInt($(a).find("#roll").text(),10) >
						parseInt($(b).find("#roll").text(),10);
				},
				by_per:function(a,b){
					return $(a).find("#present").text() >
						$(b).find("#present").text();
				},
				by_name:function(a,b){
					return $(a).find("#first_name").text()+$(a).find("#last_name").text() >
						$(b).find("#first_name").text()+$(b).find("#last_name").text();
				},
				by_check:function(a,b){
					return ($(a).find("#present_btn").text()) >
						($(b).find("#present_btn").text());
				}
			};
			function sorter(comp_by){
				var sort=[].sort();
				var $StudentListContainer =$("li.student");
				var OrderedDivs =$StudentListContainer.sort(comp_by);
				$("#StudentListContainer").html(OrderedDivs);
			};
			function rev_sorter(comp_by){
				var $StudentListContainer =$("li.student");
				var OrderedDivs =$StudentListContainer.sort(function(a,b){
					return !comp_by(a,b)
				});
				$("#StudentListContainer").html(OrderedDivs);
			};
			var order='DSC';

			function reorderdiv(BY){
				if(BY==order)
				{
					alert("reordering "+order+"=>"+'DSC');
					rev_sorter(sorterfn[BY]);
					order='DSC';
				}
				else
				{
					alert("reordering "+order+"=>"+BY);
					sorter(sorterfn[BY]);
					order=BY;
				}
			};