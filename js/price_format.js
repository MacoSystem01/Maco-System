
            $(function(){
                $('#example1').priceFormat();
                $('#example2').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    centsLimit: 0
                });
                $('#example22').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    centsLimit: 0
                });
                $('.cantExample').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    centsLimit: 0
                });
                
                
                $('#example3').priceFormat({
                    prefix: '',
                    thousandsSeparator: '',
					clearOnEmpty: true
                });
                $('#example4').priceFormat({
                    limit: 2,
                    centsLimit: 1
                });
                $('#example5').priceFormat({
                    clearPrefix: true
                });
                $('#example6').priceFormat({
                    allowNegative: true
                });
				$('#example7').priceFormat({
					prefix: 'R$',
                    suffix: '$$',
					clearSuffix: true,
					clearPrefix: true
                });
				
                $('#example8').priceFormat({
                    prefix: '',
                    thousandsSeparator: '',
					insertPlusSign: true
                });
				
				$('#example9').priceFormat();
				$("#unmask-test").click(function(){
					alert($('#example6').unmask());
				});
				
				$("#unprice-test").click(function(){
					$('#example7').unpriceFormat();
				});
				
				$("#price-test").click(function(){
					$('#example7').priceFormat({
						prefix: 'R$',
	                    suffix: '$$',
						clearSuffix: true,
						clearPrefix: true
	                });
				});
				
				$('#htmlfield').priceFormat({
                    prefix: 'R$ ',
                    centsSeparator: ',',
                    thousandsSeparator: '.',
					insertPlusSign: true
				});
            });
