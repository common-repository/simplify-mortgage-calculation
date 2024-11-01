/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function($) {
    $("#resetmrg").click(function() {
        $("#loan_amount_mrg").val("");
        $("#down_payment_mrg").val("");
        $("#years_mrg").val("");
        $("#interest_mrg").val("");
        $("#showresultmor").html("Result of Calculation");
    });
    $("#calculateloan").click(function() {
        var loan_amount = parseFloat($("#loan_amount_mrg").val());
        var downpayment = parseFloat($("#down_payment_mrg").val());
        var months = parseInt($("#years_mrg").val());
        var interest_rate = parseFloat($("#interest_mrg").val());
        var totalinterest = parseFloat((loan_amount / 100) * interest_rate);
        var amount_to_paid = loan_amount + totalinterest;
        var amount_after_downpayment = amount_to_paid - downpayment;
        var per_month_installament = amount_after_downpayment / months;
        per_month_installament = per_month_installament.toFixed(2);
        if (loan_amount < downpayment) {
            $("#showresultmor").html("Bad Inputs");
        } else if ($.isNumeric(amount_to_paid)) {
            $("#showresultmor").html("$" + per_month_installament + " /Month");
        } else if (loan_amount == "" || downpayment == "" || months == "" || interest_rate == "") {
            $("#showresultmor").html("Put All Fields");
        } else {
            $("#showresultmor").html("Bad Inputs");
        }
    });
});


