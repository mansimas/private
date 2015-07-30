function clear_cache(ssRoute){
	if($('#cc').css('display') == 'none'){
		$.ajax({
			type: 'post',
			url : ssRoute,
			beforeSend: function( xhr ) {
				$('#cc').show();
			},
			success: function(result)
			{
				$('#cc').hide();
			}
		});
	}
	else{
		return false;
	}
}

function confirmation(ssMsg)
{
	var chks=document.getElementsByName('chk_delete[]');
    var hasChecked = false;    
    for (var i = 0; i < chks.length; i++)
    {
        if (chks[i].checked)
        {
            hasChecked = true;
            break;
        }        
    }
    
    if (hasChecked == false)
    {	
        alert("Please select at least one.");
        return false;
    }
	var msg = "this record";
    return confirm("Are you sure you want to "+msg+"?");
}

function quicksearch(route, page, ssDiv, ssPerPage)
{
	quicksearchresult(route, page, ssDiv, ssPerPage);
	// it is for when checkbox checked in 
	/*if(ssflag == true)
	{
		setTimeout(function(){
			quicksearchresult(route, page, ssDiv);
		}, 2000);
		quicksearchresult(route, page, ssDiv);
	}
	else
	{
		quicksearchresult(route, page, ssDiv);
	}*/
}
var calculationRequest = null;

function quicksearchresult(route, page, ssDiv, ssPerPage)
{
	$("#refine_filter_boxes").empty();
	var category = [];
	var city = [];
	var cityIds = [];
	var language = [];
	var rating = [];
	var paymentoption = [];
	var chkinsurance = [];
	$("input:checkbox[name=category]:checked").each(function()
	{
		category.push($(this).val());
		$("#refine_filter_boxes").append('<span class="remove_link">'+$("#service_"+$(this).val()).val()+'<button onClick="removefilter(\'chk_service_'+$(this).val()+'\','+page+','+ssPerPage+')" type="button" class="close" aria-hidden="true">&times;</button></span>');
	});
	$("input:checkbox[name=city]:checked").each(function()
	{
		//city.push($(this).val());
		//$("#refine_filter_boxes").append('<span class="remove_link">'+$(this).val()+'<button onClick="removefilter(\'chk_city_'+$(this).val()+'\','+page+','+ssPerPage+')" type="button" class="close" aria-hidden="true">&times;</button></span>');
		var City = $(this).val();
		asCity = City.split("~~");
		city.push(asCity[1]);
		cityIds.push(asCity[0]);
		$("#refine_filter_boxes").append('<span class="remove_link">'+asCity[1]+'<button onClick="removefilter(\'chk_city_'+asCity[0]+'\','+page+','+ssPerPage+')" type="button" class="close" aria-hidden="true">&times;</button></span>');
	});
	$("input:checkbox[name=language]:checked").each(function()
	{
		language.push($(this).val());
		$("#refine_filter_boxes").append('<span class="remove_link">'+$("#language_"+$(this).val()).val()+'<button onClick="removefilter(\'chk_language_'+$(this).val()+'\','+page+','+ssPerPage+')" type="button" class="close" aria-hidden="true">&times;</button></span>');
	});
	$("input:checkbox[name=rating]:checked").each(function()
	{
		rating.push($(this).val());
		$("#refine_filter_boxes").append('<span class="remove_link">'+$("#rating_"+$(this).val()).val()+'<button onClick="removefilter(\'chk_rating_'+$(this).val()+'\','+page+','+ssPerPage+')" type="button" class="close" aria-hidden="true">&times;</button></span>');
	});
	$("input:checkbox[name=paymentoption]:checked").each(function()
	{
		paymentoption.push($(this).val());
		$("#refine_filter_boxes").append('<span class="remove_link">'+$("#payment_"+$(this).val()).val()+'<button onClick="removefilter(\'chk_payment_'+$(this).val()+'\','+page+','+ssPerPage+')" type="button" class="close" aria-hidden="true">&times;</button></span>');
	});
	$("input:checkbox[name=chk_insurance]:checked").each(function()
	{
		chkinsurance.push($(this).val());
		$("#refine_filter_boxes").append('<span class="remove_link">'+$("#insurance_"+$(this).val()).val()+'<button onClick="removefilter(\'chk_insurance_'+$(this).val()+'\','+page+','+ssPerPage+')" type="button" class="close" aria-hidden="true">&times;</button></span>');
	});
	drpinsurances = $("#admin_medicalbundle_insurance_insurances").val();	
	if(drpinsurances != null)
		chkinsurance = $.merge(chkinsurance, drpinsurances);
	$("#company_listing_loader").show("fast"); 
	
	if(calculationRequest != null)
        calculationRequest.abort();

	calculationRequest = $.ajax({
				type: 'post',
				url : route,
				data: "ssSearchParam="+$("#ssSearchParam").val()+"&per_page="+ssPerPage+"&page="+page+"&category_ids="+category+"&city_name="+city+"&language="+language+"&rateslider="+rating+"&paymentoption="+paymentoption+"&rate_popular="+$("#rating_popular_id").val()+"&insurace_ids="+chkinsurance,
				success: function(result)
						{
                            $("#all_category_li>ul>li.active").removeClass("active");
							$("#"+ssDiv).html(result);
							$("#company_listing_loader").hide("fast");							
							var calculationRequest = null;
							$.ajax({
								type: 'post',
								url : route,
								data: 'banner=1&category_ids='+category+'&city_name='+cityIds,
								success: function(result)
										{
											$("#testbannersucc").html(result);	
											var bannerFinalheight = ((parseInt($(".refine_search").height()) > parseInt($(".companylist_container").height())) ? parseInt($(".refine_search").height()) : parseInt($(".companylist_container").height()));
											var bannerheight = bannerFinalheight - 270 + 35;
											var snHeight = (parseInt($("#testbannersucc").height()) + 10);							
											if(snHeight < bannerheight && (category != '' || cityIds != ''))
											{
												$.ajax({
													type: 'post',
													url : route,
													data: 'banner=1&ssFlag=1&category_ids='+$("#notbanner_ids").val(),
													success: function(result)
															{
																$("#testbannersucc").append(result);												
															}
													});
											}
																		
										}
								});	
						}
			});
}
function savecompany(snId, route)
{
	$("#company_listing_loader").show("fast"); 
	$.ajax({
				type: 'get',
				url : route,
				data: "id="+snId,
				success: function(result)
						{
							$("#save_clinic_count").html(result);
							$("#save_to_list_div_id_"+snId).hide();
							$("#saved_div_id_"+snId).show();
							$("#company_listing_loader").hide("fast");
						}
			});
}

function getQuotedetail(route, ssUpdateDiv)
{
	$("#loader").show("fast"); 
	$.ajax({
				type: 'get',
				url : route,				
				success: function(result)
						{
							$("#"+ssUpdateDiv).html(result);							
							$("#loader").hide("fast");
						}
			});
}

function removeData(route, id, ssDiv)
{
	ssFlag = confirm("Are you sure you want to delete?");
	if(ssFlag == true)
	{
		$("#loader").show("fast");
		$.ajax({
				type: 'get',
				url : route,
				data: "id="+id,
				success: function(result)
						{
							snCount = parseInt($("#save_clinic_count").text()) - 1;
							$("#save_clinic_count").html(snCount);
							$("#"+ssDiv).html(result);
							$("#loader").hide("fast"); 
						}
			});
	}
}

function updateSpecialoffer(ssRoute,mainspecialoffer,updatediv)
{
	$.ajax({
		type: 'post',
		url : ssRoute,
		data: 'specialoffer_type='+mainspecialoffer,
		success: function(result)
		{			
			$("#"+updatediv).html(result);
		}
	});
}

function update_banner_count(ssBannerid,ssRoute){
	$.ajax({
		type: 'post',
		url : ssRoute,
		data: 'banner_id='+ssBannerid,
		success: function(result)
		{			
		}
	});
}
function disableinquiryandfinalprice()
{
	if($("#admin_medicalbundle_company_disable_quotes").is(':checked'))
	{
		$("#admin_medicalbundle_company_premium_company").attr("disabled",true);
		$("#admin_medicalbundle_company_final_price_info").attr("disabled",true);		
	}
	else
	{
		$("#admin_medicalbundle_company_premium_company").attr("disabled",false);
		$("#admin_medicalbundle_company_final_price_info").attr("disabled",false);	
	}
}