<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'BOOK';

		/* data for selected record, or defaults if none is selected */
		var data = {
			teams: <?php echo json_encode(array('id' => $rdata['teams'], 'value' => $rdata['teams'], 'text' => $jdata['teams'])); ?>,
			id_no: <?php echo json_encode(array('id' => $rdata['id_no'], 'value' => $rdata['id_no'], 'text' => $jdata['id_no'])); ?>,
			phone: <?php echo json_encode($jdata['phone']); ?>,
			name: <?php echo json_encode($jdata['name']); ?>,
			mode: <?php echo json_encode(array('id' => $rdata['mode'], 'value' => $rdata['mode'], 'text' => $jdata['mode'])); ?>,
			mpesa: <?php echo json_encode($jdata['mpesa']); ?>,
			paypal: <?php echo json_encode($jdata['paypal']); ?>,
			bank: <?php echo json_encode($jdata['bank']); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for teams */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'teams' && d.id == data.teams.id)
				return { results: [ data.teams ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for id_no */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'id_no' && d.id == data.id_no.id)
				return { results: [ data.id_no ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for id_no autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'id_no' && d.id == data.id_no.id){
				$j('#phone' + d[rnd]).html(data.phone);
				$j('#name' + d[rnd]).html(data.name);
				return true;
			}

			return false;
		});

		/* saved value for mode */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'mode' && d.id == data.mode.id)
				return { results: [ data.mode ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for mode autofills */
		cache.addCheck(function(u, d){
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'mode' && d.id == data.mode.id){
				$j('#mpesa' + d[rnd]).html(data.mpesa);
				$j('#paypal' + d[rnd]).html(data.paypal);
				$j('#bank' + d[rnd]).html(data.bank);
				return true;
			}

			return false;
		});

		cache.start();
	});
</script>

