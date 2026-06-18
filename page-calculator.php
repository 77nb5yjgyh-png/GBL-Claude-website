<?php
/**
 * Template Name: Peptide Calculator
 * Template Post Type: page
 */
get_header();
?>

<div class="page-header">
	<div class="container">
		<span class="label-overline">Research Tools</span>
		<h1 class="page-title">Peptide Calculator</h1>
		<p class="page-desc">Reconstitution volumes, draw amounts, insulin units, and intranasal dosing — all in one place.</p>
	</div>
</div>

<div class="container section-pad">
	<div class="calc-layout">

		<!-- Mode tabs -->
		<div class="calc-tabs" role="tablist" aria-label="Calculator modes">
			<button class="calc-tab active" data-mode="recon"   role="tab" aria-selected="true"  aria-controls="mode-recon">Reconstitution</button>
			<button class="calc-tab"        data-mode="reverse" role="tab" aria-selected="false" aria-controls="mode-reverse">Reverse BAC</button>
			<button class="calc-tab"        data-mode="nasal"   role="tab" aria-selected="false" aria-controls="mode-nasal">Intranasal</button>
		</div>

		<!-- ── MODE: RECON ── -->
		<div id="mode-recon" class="calc-card" role="tabpanel" aria-labelledby="recon-tab">
			<h2 style="font-size:18px;margin-bottom:6px;">Reconstitution Calculator</h2>
			<p style="color:var(--gbl-muted);font-size:14px;margin-bottom:28px;">Enter your vial size and the amount of BAC water added, then set your dose to get draw volumes and units.</p>

			<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
				<div class="calc-field">
					<label class="calc-label" for="r-vial">Vial size <span>mg</span></label>
					<input type="number" id="r-vial" class="calc-input" placeholder="5" min="0.01" step="0.01" inputmode="decimal">
				</div>
				<div class="calc-field">
					<label class="calc-label" for="r-bac">BAC water added <span>mL</span></label>
					<input type="number" id="r-bac" class="calc-input" placeholder="2" min="0.01" step="0.01" inputmode="decimal">
				</div>
				<div class="calc-field">
					<label class="calc-label" for="r-dose">Desired dose <span>mcg</span></label>
					<input type="number" id="r-dose" class="calc-input" placeholder="250" min="1" step="1" inputmode="decimal">
				</div>
				<div class="calc-field">
					<label class="calc-label" for="r-syringe">Syringe type</label>
					<select id="r-syringe" class="calc-input" style="cursor:pointer;">
						<option value="100">U-100 (1 mL / 100 units)</option>
						<option value="50">U-50 (0.5 mL / 50 units)</option>
					</select>
				</div>
			</div>

			<button class="btn btn-primary" id="r-calc-btn" style="width:100%;justify-content:center;margin-top:8px;">
				Calculate
			</button>

			<div class="calc-results" id="r-results" style="display:none;">
				<div class="calc-result-title">Results</div>
				<div class="calc-result-grid">
					<div class="calc-result-item calc-result-featured">
						<div class="calc-result-label">Draw Volume</div>
						<div class="calc-result-value" id="r-volume">—<span class="unit">mL</span></div>
					</div>
					<div class="calc-result-item">
						<div class="calc-result-label">Insulin Units</div>
						<div class="calc-result-value" id="r-units">—<span class="unit">IU</span></div>
					</div>
					<div class="calc-result-item">
						<div class="calc-result-label">Concentration</div>
						<div class="calc-result-value" id="r-conc">—<span class="unit">mcg/mL</span></div>
					</div>
					<div class="calc-result-item">
						<div class="calc-result-label">Doses Per Vial</div>
						<div class="calc-result-value" id="r-doses">—</div>
					</div>
				</div>

				<!-- Syringe visualizer -->
				<div class="syringe-wrap">
					<canvas id="r-syringe-canvas" width="320" height="80" aria-label="Syringe fill level visualizer"></canvas>
				</div>

				<!-- Reference table -->
				<div style="margin-top:20px;">
					<div class="calc-result-title" style="margin-bottom:14px;">Reference Table</div>
					<table id="r-ref-table" style="width:100%;border-collapse:collapse;font-size:13px;color:#fff;">
						<thead>
							<tr>
								<th style="text-align:left;padding:8px 10px;background:rgba(255,255,255,.06);border-radius:6px 0 0 6px;font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.5);">Dose (mcg)</th>
								<th style="text-align:left;padding:8px 10px;background:rgba(255,255,255,.06);font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.5);">Volume (mL)</th>
								<th style="text-align:left;padding:8px 10px;background:rgba(255,255,255,.06);border-radius:0 6px 6px 0;font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.5);">Units</th>
							</tr>
						</thead>
						<tbody id="r-ref-tbody"></tbody>
					</table>
				</div>
				<p class="calc-disclaimer">Mathematical reference only. Verify all calculations before laboratory use.</p>
			</div>
		</div>

		<!-- ── MODE: REVERSE BAC ── -->
		<div id="mode-reverse" class="calc-card" role="tabpanel" aria-labelledby="reverse-tab" style="display:none;">
			<h2 style="font-size:18px;margin-bottom:6px;">Reverse BAC Calculator</h2>
			<p style="color:var(--gbl-muted);font-size:14px;margin-bottom:28px;">Know your target concentration? Enter your vial size and desired mcg/mL to get the exact BAC water volume to add.</p>

			<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
				<div class="calc-field">
					<label class="calc-label" for="rb-vial">Vial size <span>mg</span></label>
					<input type="number" id="rb-vial" class="calc-input" placeholder="5" min="0.01" step="0.01" inputmode="decimal">
				</div>
				<div class="calc-field">
					<label class="calc-label" for="rb-conc">Target concentration <span>mcg/mL</span></label>
					<input type="number" id="rb-conc" class="calc-input" placeholder="2500" min="1" step="1" inputmode="decimal">
				</div>
				<div class="calc-field">
					<label class="calc-label" for="rb-dose">Dose per injection <span>mcg</span></label>
					<input type="number" id="rb-dose" class="calc-input" placeholder="250" min="1" step="1" inputmode="decimal">
				</div>
			</div>

			<button class="btn btn-primary" id="rb-calc-btn" style="width:100%;justify-content:center;margin-top:8px;">Calculate BAC Volume</button>

			<div class="calc-results" id="rb-results" style="display:none;">
				<div class="calc-result-title">Results</div>
				<div class="calc-result-grid">
					<div class="calc-result-item calc-result-featured">
						<div class="calc-result-label">Add BAC Water</div>
						<div class="calc-result-value" id="rb-bac-vol">—<span class="unit">mL</span></div>
					</div>
					<div class="calc-result-item">
						<div class="calc-result-label">Volume Per Dose</div>
						<div class="calc-result-value" id="rb-dose-vol">—<span class="unit">mL</span></div>
					</div>
					<div class="calc-result-item">
						<div class="calc-result-label">Units Per Dose</div>
						<div class="calc-result-value" id="rb-units">—<span class="unit">IU</span></div>
					</div>
					<div class="calc-result-item">
						<div class="calc-result-label">Doses Per Vial</div>
						<div class="calc-result-value" id="rb-doses">—</div>
					</div>
				</div>
				<p class="calc-disclaimer">Mathematical reference only. Verify all calculations before laboratory use.</p>
			</div>
		</div>

		<!-- ── MODE: NASAL ── -->
		<div id="mode-nasal" class="calc-card" role="tabpanel" aria-labelledby="nasal-tab" style="display:none;">
			<h2 style="font-size:18px;margin-bottom:6px;">Intranasal Calculator</h2>
			<p style="color:var(--gbl-muted);font-size:14px;margin-bottom:28px;">For intranasally administered peptides (Semax, Selank, DSIP, Oxytocin). Standard pump: 0.1 mL (100 µL) per spray.</p>

			<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
				<div class="calc-field">
					<label class="calc-label" for="n-peptide">Peptide amount <span>mg</span></label>
					<input type="number" id="n-peptide" class="calc-input" placeholder="30" min="0.01" step="0.01" inputmode="decimal">
				</div>
				<div class="calc-field">
					<label class="calc-label" for="n-solution">Solution volume <span>mL</span></label>
					<input type="number" id="n-solution" class="calc-input" placeholder="3" min="0.1" step="0.1" inputmode="decimal">
				</div>
				<div class="calc-field">
					<label class="calc-label" for="n-dose">Desired dose <span>mcg</span></label>
					<input type="number" id="n-dose" class="calc-input" placeholder="600" min="1" step="1" inputmode="decimal">
				</div>
				<div class="calc-field">
					<label class="calc-label" for="n-spray">Volume per spray <span>mL</span></label>
					<input type="number" id="n-spray" class="calc-input" value="0.1" min="0.01" step="0.01" inputmode="decimal">
				</div>
			</div>

			<button class="btn btn-primary" id="n-calc-btn" style="width:100%;justify-content:center;margin-top:8px;">Calculate Sprays</button>

			<div class="calc-results" id="n-results" style="display:none;">
				<div class="calc-result-title">Results</div>
				<div class="calc-result-grid">
					<div class="calc-result-item calc-result-featured">
						<div class="calc-result-label">Sprays Per Dose</div>
						<div class="calc-result-value" id="n-sprays-dose">—<span class="unit">sprays</span></div>
					</div>
					<div class="calc-result-item">
						<div class="calc-result-label">mcg Per Spray</div>
						<div class="calc-result-value" id="n-mcg-spray">—<span class="unit">mcg</span></div>
					</div>
					<div class="calc-result-item">
						<div class="calc-result-label">Concentration</div>
						<div class="calc-result-value" id="n-conc">—<span class="unit">mcg/mL</span></div>
					</div>
					<div class="calc-result-item">
						<div class="calc-result-label">Total Doses</div>
						<div class="calc-result-value" id="n-total-doses">—</div>
					</div>
				</div>
				<p class="calc-disclaimer">Mathematical reference only. For intranasal research administration only.</p>
			</div>
		</div>

	</div>

	<!-- Peptide Reference Table -->
	<div style="margin-top:60px;">
		<h2 class="section-title" style="margin-bottom:8px;font-size:24px;">Quick Reference — Common Reconstitution Setups</h2>
		<p style="color:var(--gbl-muted);font-size:14px;margin-bottom:28px;">Standard setups used in research protocols. Concentration = vial size ÷ BAC water.</p>

		<div style="overflow-x:auto;border-radius:var(--radius-lg);border:1px solid var(--gbl-border);">
			<table style="width:100%;border-collapse:collapse;background:var(--gbl-card);font-size:14px;">
				<thead>
					<tr style="background:var(--gbl-elevated);">
						<th style="text-align:left;padding:14px 18px;font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--gbl-muted);">Vial Size</th>
						<th style="text-align:left;padding:14px 18px;font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--gbl-muted);">BAC Water</th>
						<th style="text-align:left;padding:14px 18px;font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--gbl-muted);">Concentration</th>
						<th style="text-align:left;padding:14px 18px;font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--gbl-muted);">250 mcg dose</th>
						<th style="text-align:left;padding:14px 18px;font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--gbl-muted);">500 mcg dose</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$rows = [
						[ '2 mg', '1 mL',  '2,000 mcg/mL', '0.125 mL / 12.5 IU', '0.25 mL / 25 IU' ],
						[ '5 mg', '1 mL',  '5,000 mcg/mL', '0.05 mL / 5 IU',     '0.10 mL / 10 IU' ],
						[ '5 mg', '2 mL',  '2,500 mcg/mL', '0.10 mL / 10 IU',    '0.20 mL / 20 IU' ],
						[ '5 mg', '2.5 mL','2,000 mcg/mL', '0.125 mL / 12.5 IU', '0.25 mL / 25 IU' ],
						[ '10 mg','2 mL',  '5,000 mcg/mL', '0.05 mL / 5 IU',     '0.10 mL / 10 IU' ],
						[ '10 mg','4 mL',  '2,500 mcg/mL', '0.10 mL / 10 IU',    '0.20 mL / 20 IU' ],
					];
					foreach ( $rows as $i => $row ) :
						$bg = $i % 2 === 0 ? '' : 'background:var(--gbl-elevated);';
					?>
						<tr style="<?php echo $bg; ?>border-bottom:1px solid var(--gbl-border);">
							<?php foreach ( $row as $j => $cell ) : ?>
								<td style="padding:13px 18px;font-weight:<?php echo $j === 2 ? '700;color:var(--gbl-blue)' : '600'; ?>;">
									<?php echo esc_html( $cell ); ?>
								</td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php get_footer(); ?>
