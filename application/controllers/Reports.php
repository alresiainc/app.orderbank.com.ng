<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load_global();
		$this->load->model('reports_model', 'reports');
	}

	public function sales_movement($store_id = null, $item_ids = null, $warehouse_id = null)
	{

		// SALES DATA
		$sales_select = array(
			//salesitems data
			'a.sales_qty as quantity',
			'a.price_per_unit',
			'a.tax_type',
			'a.tax_id',
			'a.tax_amt',
			'a.discount_type',
			'a.discount_input',
			'a.discount_amt',
			'a.unit_total_cost',
			'a.total_cost',
			'a.status',

			// sales
			'b.sales_date as transaction_date',
			'b.warehouse_id as warehouse_from',
			'b.store_id',
			'b.created_date',
			'b.created_time',
			'b.sales_code as transaction_id',
			//item
			'c.id as item_id',
			'c.item_name',    // Item name
			'c.item_image',  // Item image
			'c.description as item_description', // Item description
			'c.price as item_price',  // Item price
			'c.sales_price as item_sales_price'

		);
		$sales = $this->db->from('db_salesitems as a');
		$sales->join('db_sales as b', 'b.id=a.sales_id', 'left');
		$sales->join('db_items as c', 'c.id=a.item_id', 'left');

		if ($item_ids && is_array($item_ids)) {
			$sales->where_in('c.id', $item_ids);
		}
		if ($store_id) {
			$sales->where('b.store_id', $store_id);
		}

		if ($warehouse_id) {
			$sales->where('b.warehouse_id', $warehouse_id);
		}

		$sales->select($sales_select);


		$sales_data = $sales->get()->result();
		return array_map(function ($item) {
			$item->data_time = $item->created_date . ' ' . $item->created_time;
			$item->transaction_type = "sales";
			$item->warehouse_to = null;
			return $item;
		}, $sales_data);
	}

	public function purchase_movement($store_id = null, $item_ids = null, $warehouse_id = null)
	{

		// SALES DATA
		$sales_select = array(
			//salesitems data
			'a.purchase_qty as quantity',
			'a.price_per_unit',
			'a.tax_type',
			'a.tax_id',
			'a.tax_amt',
			'a.discount_type',
			'a.discount_input',
			'a.discount_amt',
			'a.unit_total_cost',
			'a.total_cost',
			'a.status',

			// sales
			'b.purchase_date as transaction_date',
			'b.warehouse_id as warehouse_to',
			'b.store_id',
			'b.created_date',
			'b.created_time',
			'b.purchase_code as transaction_id',
			//item
			'c.id as item_id',
			'c.item_name',    // Item name
			'c.item_image',  // Item image
			'c.description as item_description', // Item description
			'c.price as item_price',  // Item price
			'c.sales_price as item_sales_price'

		);
		$sales = $this->db->from('db_purchaseitems as a');
		$sales->join('db_purchase as b', 'b.id=a.purchase_id', 'left');
		$sales->join('db_items as c', 'c.id=a.item_id', 'left');

		if ($item_ids && is_array($item_ids)) {
			$sales->where_in('c.id', $item_ids);
		}
		if ($store_id) {
			$sales->where('b.store_id', $store_id);
		}
		if ($warehouse_id) {
			$sales->where('b.warehouse_id', $warehouse_id);
		}

		$sales->select($sales_select);


		$sales_data = $sales->get()->result();
		return array_map(function ($item) {
			$item->data_time = $item->created_date . ' ' . $item->created_time;
			$item->transaction_type = "purchased";
			$item->warehouse_from = null;
			return $item;
		}, $sales_data);
	}

	public function waybill_movement($store_id = null, $item_ids = null, $warehouse_id = null)
	{

		// SALES DATA
		$sales_select = array(
			//salesitems data
			'a.transfer_qty as quantity',
			'a.warehouse_from',
			'a.warehouse_to',
			// 'a.tax_type',
			// 'a.tax_id',
			// 'a.tax_amt',
			// 'a.discount_type',
			// 'a.discount_input',
			// 'a.discount_amt',
			// 'a.unit_total_cost',
			// 'a.total_cost',
			'a.status',


			// sales
			'b.transfer_date as transaction_date',
			'b.store_id',
			'b.created_date',
			'b.created_time',
			'b.reference_no as transaction_id',
			//item
			'c.id as item_id',
			'c.item_name',    // Item name
			'c.item_image',  // Item image
			'c.description as item_description', // Item description
			'c.price as item_price',  // Item price
			'c.sales_price as item_sales_price'

		);
		$sales = $this->db->from('db_stocktransferitems as a');
		$sales->join('db_stocktransfer as b', 'b.id=a.stocktransfer_id', 'left');
		$sales->join('db_items as c', 'c.id=a.item_id', 'left');
		if ($item_ids && is_array($item_ids)) {
			$sales->where_in('c.id', $item_ids);
		}
		if ($store_id) {
			$sales->where('b.store_id', $store_id);
		}

		if ($warehouse_id) {
			$sales->where('b.warehouse_from', $warehouse_id);
			$sales->where('b.warehouse_to', $warehouse_id);
		}

		$sales->select($sales_select);


		$sales_data = $sales->get()->result();
		return array_map(function ($item) {
			$item->data_time = $item->created_date . ' ' . $item->created_time;
			$item->transaction_type = "transfer";
			$item->tax_type = null;
			$item->tax_id = null;
			$item->tax_amt = null;
			$item->discount_type = null;
			$item->discount_input = null;
			$item->discount_amt = null;
			$item->unit_total_cost = null;
			$item->total_cost = null;
			// $item->transaction_id = sprintf('WB/%s/%02d/%05d', date('Y', strtotime($item->created_date)), $item->store_id, $item->id);

			return $item;
		}, $sales_data);
	}

	public function return_movement($store_id = null, $item_ids = null, $warehouse_id = null)
	{

		// SALES DATA
		$sales_select = array(
			//salesitems data
			'a.return_qty as quantity',
			'a.price_per_unit',
			'a.tax_type',
			'a.tax_id',
			'a.tax_amt',
			'a.discount_type',
			'a.discount_input',
			'a.discount_amt',
			'a.unit_total_cost',
			'a.total_cost',
			'a.status',

			// sales
			'b.return_date as transaction_date',
			'b.warehouse_id as warehouse_to',
			'b.store_id',
			'b.created_date',
			'b.created_time',
			'b.return_code as transaction_id',

			//item
			'c.id as item_id',
			'c.item_name',    // Item name
			'c.item_image',  // Item image
			'c.description as item_description', // Item description
			'c.price as item_price',  // Item price
			'c.sales_price as item_sales_price'

		);
		$sales = $this->db->from('db_purchaseitemsreturn as a');
		$sales->join('db_purchasereturn as b', 'b.id=a.return_id', 'left');
		$sales->join('db_items as c', 'c.id=a.item_id', 'left');
		if ($item_ids && is_array($item_ids)) {
			$sales->where_in('c.id', $item_ids);
		}
		if ($store_id) {
			$sales->where('b.store_id', $store_id);
		}

		if ($warehouse_id) {
			$sales->where('b.warehouse_id', $warehouse_id);
		}
		$sales->select($sales_select);


		$sales_data = $sales->get()->result();
		return array_map(function ($item) {
			$item->data_time = $item->created_date . ' ' . $item->created_time;
			$item->transaction_type = "purchased_return";
			$item->warehouse_from = null;
			return $item;
		}, $sales_data);
	}


	public function movements_reports($data = [])
	{
		$warehouse_id = $data['warehouse_id'] ?? 2;
		$item_ids = $data['item_ids'] ?? null;
		$store_id = $data['store_id'] ?? null;

		// Pagination parameters
		$limit = $data['limit']; // Number of items per page
		$offset = $data['offset'] ?? 0; // Starting index

		// Search filters
		$search = $data['search'] ?? null; // Search term
		$transaction_type = $data['transaction_type'] ?? null; // Filter by transaction type
		$start_date = $data['start_date'] ?? null; // Date range start
		$end_date = $data['end_date'] ?? null; // Date range end

		// Fetch movements
		$sales_movement = $this->sales_movement($store_id, $item_ids, $warehouse_id);
		$purchase_movement = $this->purchase_movement($store_id, $item_ids, $warehouse_id);
		$waybill_movement = $this->waybill_movement($store_id, $item_ids, $warehouse_id);
		$return_movement = $this->return_movement($store_id, $item_ids, $warehouse_id);

		// Combine all movements
		$merged = array_merge($sales_movement, $purchase_movement, $waybill_movement, $return_movement);

		// Sort transactions by date and time
		usort($merged, function ($a, $b) {
			return strtotime($a->data_time) - strtotime($b->data_time);
		});

		// Assign unique IDs after sorting
		foreach ($merged as $index => &$item) {
			$item->id = $index + 1; // Generate a unique ID starting from 1
		}



		// Initialize stock tracking for each product
		$product_opening = []; // Associative array: product_id => opening_quantity

		$filtered = array_map(function ($item) use ($warehouse_id, &$product_opening) {

			// Determine movement type
			if ($item->transaction_type == 'transfer' && $item->warehouse_from == $warehouse_id) {
				$item->transaction_type = 'waybill_sent';
			} elseif ($item->transaction_type == 'transfer' && $item->warehouse_to == $warehouse_id) {
				$item->transaction_type = 'waybill_received';
			}

			if ($item->warehouse_from == $warehouse_id) {
				$item->movement_type = 'outgoing';
			} else {
				$item->movement_type = 'incoming';
			}

			// Ensure product tracking is initialized
			$product_id = $item->item_id; // Replace with `item_id` if available
			if (!isset($product_opening[$product_id])) {
				$product_opening[$product_id] = 0; // Default opening quantity for the product
			}

			// Calculate opening and closing quantities for the product
			$item->opening_quantity = $product_opening[$product_id];

			if ($item->movement_type == 'incoming') {
				$product_opening[$product_id] += $item->quantity; // Add for incoming
			} elseif ($item->movement_type == 'outgoing') {
				$product_opening[$product_id] -= $item->quantity; // Subtract for outgoing
			}

			$item->closing_quantity = $product_opening[$product_id];

			return $item;
		}, $merged);

		// Apply search filters
		$filtered = array_filter($filtered, function ($item) use ($search, $transaction_type, $start_date, $end_date) {
			$matches = true;

			if ($search) {
				$matches &= stripos($item->item_name, $search) !== false;
			}
			if ($transaction_type) {
				$matches &= $item->transaction_type === $transaction_type;
			}
			if ($start_date) {
				$matches &= strtotime($item->data_time) >= strtotime($start_date);
			}
			if ($end_date) {
				$matches &= strtotime($item->data_time) <= strtotime($end_date);
			}

			return $matches;
		});

		// Paginate the results
		$paginated_formatted = array_slice($filtered, $offset, $limit);

		// Return paginated and filtered results with metadata
		return [
			'data' => $paginated_formatted,
			'total' => count($filtered),
			'limit' => $limit,
			'offset' => $offset
		];
	}

	public function stock_movement_json_data()
	{
		// Fetch POST parameters from DataTable
		$store_id = $this->input->post('store_id');
		$item_ids = $this->input->post('item_ids');
		$search = $this->input->post('search')['value'] ?? null; // DataTable sends search in 'search[value]'
		$transaction_type = $this->input->post('transaction_type');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$offset = $this->input->post('start'); // DataTable uses 'start' for offset
		$limit = $this->input->post('length'); // DataTable uses 'length' for limit
		$warehouse_id = $this->input->post('warehouse_id');
		$draw = $this->input->post('draw');

		// Options to pass to the report function
		$options = [
			'store_id' => $store_id,
			'item_ids' => $item_ids,
			'search' => $search,
			'transaction_type' => $transaction_type,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'offset' => $offset,
			'limit' => $limit,
			'warehouse_id' => $warehouse_id
		];

		// Fetch the report
		$list = $this->movements_reports($options);

		// Extract the required fields
		$data = [];
		$no = $offset; // Start counter from offset

		foreach ($list['data'] as $item) {
			$no++;
			$row = [];

			// Add columns for DataTable (Customize as needed)
			$row[] = $no; // Serial number
			$row[] = $item->id; // ID of the movement
			$row[] = $item->item_name ?? ''; // Item name (ensure it's available in the data)
			$row[] = $item->transaction_type ?? ''; // Transaction type
			$row[] = $item->data_time ?? ''; // Date and time
			$row[] = $item->quantity ?? ''; // Quantity
			$row[] = $item->opening_quantity ?? ''; // Opening quantity
			$row[] = $item->closing_quantity ?? ''; // Closing quantity

			$data[] = $row;
		}

		// Output JSON in the format DataTable expects
		$output = [
			"draw" => intval($draw), // Draw counter for DataTable
			"recordsTotal" => $list['total'], // Total records before filtering
			"recordsFiltered" => $list['total'], // Total records after filtering
			"data" => $data // Data rows
		];

		echo json_encode($output);
	}

	public function stock_movement_table_body_data()
	{
		// Fetch POST parameters from DataTable
		$store_id = $this->input->post('store_id');
		$item_ids = $this->input->post('item_ids');
		$search = $this->input->post('search')['value'] ?? null; // DataTable sends search in 'search[value]'
		$transaction_type = $this->input->post('transaction_type');
		$start_date = $this->input->post('from_date');
		$end_date = $this->input->post('to_date');
		$offset = (int)$this->input->post('start'); // DataTable uses 'start' for offset
		$warehouse_id = $this->input->post('warehouse_id');

		// Options to pass to the report function
		$options = [
			'store_id' => $store_id,
			'item_ids' => $item_ids,
			'search' => $search,
			'transaction_type' => $transaction_type,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'warehouse_id' => $warehouse_id
		];

		// Log options for debugging
		log_message('error', json_encode($options));

		// Fetch the report
		$list = $this->movements_reports($options);

		if (empty($list['data'])) {
			echo "<tr><td colspan='10' class='text-center'>No data available</td></tr>";
			exit;
		}

		$no = $offset; // Start counter from offset
		$total_stock_in = 0; // Initialize total stock in
		$opening_stock = 0; // Opening stock initialization

		echo "<tr>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td>" . $list['data'][0]->opening_quantity . "</td>"; // Placeholder for remarks
		echo "</tr>";

		foreach ($list['data'] as $item) {
			$no++;
			if ($item->transaction_type == 'transfer') {
				log_message('error', 'warehouse_from ' . $item->warehouse_from);
				log_message('error', 'warehouse_to ' . $item->warehouse_to);
				log_message('error', 'warehouse ' . $warehouse_id);
			}

			// Set the opening stock for the first record
			if ($no == 1) {
				$opening_stock = $item->opening_quantity;
			}

			// Determine readable transaction type
			$transaction_type = ucfirst(str_replace('_', ' ', $item->transaction_type));
			$transaction_type_map = [

				'sales' => 'Sales',
				'waybill_sent' => 'Waybill Sent',
				'waybill_received' => 'Waybill Received',
				'purchased' => 'Purchased',
				'purchased_return' => 'Faulty'
			];


			$transaction_type = $transaction_type_map[$item->transaction_type] ?? $transaction_type;

			$get_warehouse_from_name = $item->warehouse_from ?  get_warehouse_name($item->warehouse_from) : '';
			$get_warehouse_to_name = $item->warehouse_to ?  get_warehouse_name($item->warehouse_to) : '';

			$remark_map = [
				'sales' => 'Sold recorded on Revenue',
				'waybill_received' => 'Waybill sent from ' . $get_warehouse_from_name . ' to ' . $get_warehouse_to_name . '',
				'waybill_sent' => 'Waybill sent from ' . $get_warehouse_to_name . ' to ' . $get_warehouse_from_name . '',
				'purchased' => 'Stock added from purchase record',
				'purchased_return' => 'Stock deducted as faulty product'
			];
			$remark = $remark_map[$item->transaction_type] ?? '';


			// Calculate total stock in
			$total_stock_in += $item->quantity;

			// Render table row
			echo "<tr>";
			echo "<td>" . $no . "</td>";
			echo "<td>" . show_date($item->transaction_date) . "</td>";
			echo "<td>" . $item->transaction_id . "</td>";
			echo "<td>" . $transaction_type . "</td>";
			echo "<td>" . $item->item_name . "</td>";
			echo "<td>" . $item->opening_quantity . "</td>";
			echo "<td>" . $item->quantity . "</td>";
			echo "<td>" . $item->closing_quantity . "</td>";
			echo "<td>" . $remark . "</td>"; // Placeholder for remarks
			echo "<td></td>"; // Placeholder for remarks
			echo "</tr>";
		}

		// Totals Row: Total Stock In
		echo "<tr>
              <td class='text-right text-bold' colspan='6'><b>TOTAL STOCK IN:</b></td>
              <td class='text-right text-bold'>" . $total_stock_in . "</td>
              <td colspan='3'></td>
          </tr>";

		// Totals Row: Opening Stock
		echo "<tr>
              <td class='text-right text-bold' colspan='6'><b>OPENING STOCK:</b></td>
              <td class='text-right text-bold'>" . ($total_stock_in + $opening_stock) . "</td>
              <td colspan='3'></td>
          </tr>";

		exit;
	}

	public function stock_movements_pdf()
	{
		$file_name = $this->input->get('file_name'); // Get the file_name parameter from the URL
		$download = $this->input->get('download') !== null; // Check if 'download' exists in the URL (true if present)
		// Fetch POST parameters from DataTable
		$store_id = $this->input->get('store_id');
		$item_id = $this->input->get('item_id');
		$search = $this->input->get('search')['value'] ?? null; // DataTable sends search in 'search[value]'
		$transaction_type = $this->input->get('transaction_type');
		$start_date = $this->input->get('from_date');
		$end_date = $this->input->get('to_date');
		$offset = (int)$this->input->get('start'); // DataTable uses 'start' for offset
		$warehouse_id = $this->input->get('warehouse_id');


		$item_ids = $item_id ? [$item_id] : null;


		if (!is_array($transaction_type)) {
			$transaction_type = [];
		}

		if (!is_array($warehouse_id)) {
			$warehouse_id = [];
		}

		if (!is_array($store_id)) {
			$store_id = [];
		}

		if (empty($start_date)) {
			$start_date = date('Y-m-d');
		}

		if (empty($end_date)) {
			$end_date = date('Y-m-d');
			# code...
		}

		// Options to pass to the report function
		$options = [
			'store_id' => $store_id,
			'item_ids' => $item_ids,
			'search' => $search,
			'transaction_type' => $transaction_type,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'warehouse_id' => $warehouse_id
		];

		// Log options for debugging
		log_message('error', json_encode($options));

		// Fetch the report
		$list = $this->movements_reports($options);
		$body = '';
		if (empty($list['data'])) {
			$body .=  "<tr><td colspan='10' class='text-center'>No data available</td></tr>";
		} else {



			$no = $offset; // Start counter from offset
			$total_stock_in = 0; // Initialize total stock in
			$opening_stock = 0; // Opening stock initialization

			$body .= "<tr>";
			$body .= "<td></td>";
			$body .= "<td></td>";
			$body .= "<td></td>";
			$body .= "<td></td>";
			$body .= "<td></td>";
			$body .= "<td></td>";
			$body .= "<td></td>";
			$body .= "<td></td>";
			$body .= "<td></td>";
			$body .= "<td>" . $list['data'][0]->opening_quantity . "</td>"; // Placeholder for remarks
			$body .= "</tr>";

			foreach ($list['data'] as $item) {
				$no++;
				if ($item->transaction_type == 'transfer') {
					log_message('error', 'warehouse_from ' . $item->warehouse_from);
					log_message('error', 'warehouse_to ' . $item->warehouse_to);
					log_message('error', 'warehouse ' . $warehouse_id);
				}

				// Set the opening stock for the first record
				if ($no == 1) {
					$opening_stock = $item->opening_quantity;
				}

				// Determine readable transaction type
				$transaction_type = ucfirst(str_replace('_', ' ', $item->transaction_type));
				$transaction_type_map = [

					'sales' => 'Sales',
					'waybill_sent' => 'Waybill Sent',
					'waybill_received' => 'Waybill Received',
					'purchased' => 'Purchased',
					'purchased_return' => 'Faulty'
				];


				$transaction_type = $transaction_type_map[$item->transaction_type] ?? $transaction_type;

				$get_warehouse_from_name = $item->warehouse_from ?  get_warehouse_name($item->warehouse_from) : '';
				$get_warehouse_to_name = $item->warehouse_to ?  get_warehouse_name($item->warehouse_to) : '';

				$remark_map = [
					'sales' => 'Sold recorded on Revenue',
					'waybill_received' => 'Waybill sent from ' . $get_warehouse_from_name . ' to ' . $get_warehouse_to_name . '',
					'waybill_sent' => 'Waybill sent from ' . $get_warehouse_to_name . ' to ' . $get_warehouse_from_name . '',
					'purchased' => 'Stock added from purchase record',
					'purchased_return' => 'Stock deducted as faulty product'
				];
				$remark = $remark_map[$item->transaction_type] ?? '';


				// Calculate total stock in
				$total_stock_in += $item->quantity;

				// Render table row
				$body .= "<tr>";
				$body .= "<td>" . $no . "</td>";
				$body .= "<td>" . show_date($item->transaction_date) . "</td>";
				$body .= "<td>" . $item->transaction_id . "</td>";
				$body .= "<td>" . $transaction_type . "</td>";
				$body .= "<td>" . $item->item_name . "</td>";
				$body .= "<td>" . $item->opening_quantity . "</td>";
				$body .= "<td>" . $item->quantity . "</td>";
				$body .= "<td>" . $item->closing_quantity . "</td>";
				$body .= "<td>" . $remark . "</td>"; // Placeholder for remarks
				$body .= "<td></td>"; // Placeholder for remarks
				$body .= "</tr>";
			}

			// Totals Row: Total Stock In
			$body .= "<tr>
              <td class='text-right text-bold' colspan='6'><b>TOTAL STOCK IN:</b></td>
              <td class='text-right text-bold'>" . $total_stock_in . "</td>
              <td colspan='3'></td>
          </tr>";

			// Totals Row: Opening Stock
			$body .= "<tr>
              <td class='text-right text-bold' colspan='6'><b>OPENING STOCK:</b></td>
              <td class='text-right text-bold'>" . ($total_stock_in + $opening_stock) . "</td>
              <td colspan='3'></td>
          </tr>";
		}

		$data = $this->data;
		$data['page_title'] = "Stock Movements";
		$data['body'] = $body;
		$html = $this->load->view('report-stock-movement-pdf', $data, true);
		$this->generatePDFfromPage($html, $file_name ?? 'Orders_receipt.pdf', true, $download ?? true);
	}



	public function stock_movements()
	{
		// $this->permission_check('expense_report');
		$data = $this->data;
		$data['page_title'] = "Stock Movements";
		$this->load->view('report-stock-movement', $data);
	}



	//Supplier Items Report 
	public function supplier_items()
	{
		$this->permission_check('supplier_items_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('supplier_items_report');
		$this->load->view('report-supplier_items', $data);
	}
	public function show_supplier_items_report()
	{
		echo $this->reports->show_supplier_items_report();
	}

	//Sales Report 
	public function sales()
	{
		$this->permission_check('sales_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('sales_report');
		$this->load->view('report-sales', $data);
	}
	public function show_sales_report()
	{
		echo $this->reports->show_sales_report();
	}

	public function show_income_statement_report()
	{
		echo $this->reports->show_income_statement_report();
	}

	//Sales Return Report 
	public function sales_return()
	{
		$this->permission_check('sales_return_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('sales_return_report');
		$this->load->view('report-sales-return', $data);
	}
	public function show_sales_return_report()
	{
		echo $this->reports->show_sales_return_report();
	}

	//Purchase report
	public function purchase()
	{
		$this->permission_check('purchase_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('purchase_report');
		$this->load->view('report-purchase', $data);
	}
	public function show_purchase_report()
	{
		echo $this->reports->show_purchase_report();
	}

	//Purchase Return report
	public function purchase_return()
	{
		$this->permission_check('purchase_return_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('purchase_return_report');
		$this->load->view('report-purchase-return', $data);
	}
	public function show_purchase_return_report()
	{
		echo $this->reports->show_purchase_return_report();
	}

	//Expense report
	public function expense()
	{
		$this->permission_check('expense_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('expense_report');
		$this->load->view('report-expense', $data);
	}
	public function show_expense_report()
	{
		echo $this->reports->show_expense_report();
	}
	//Profit report
	public function profit_loss()
	{
		$this->permission_check('profit_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('profit_and_loss_report');
		$this->load->view('report-profit-loss', $data);
	}

	//Profit report
	public function income_statement()
	{


		$this->permission_check('profit_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('income_statement') ?? 'Income Statement';
		$this->load->view('report-income-statement', $data);
		// var_dump($this);

	}

	public function get_profit_by_item()
	{
		echo $this->reports->get_profit_by_item();
	}
	public function get_profit_by_invoice()
	{
		echo $this->reports->get_profit_by_invoice();
	}

	//Summary report
	public function stock()
	{
		$this->permission_check('stock_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('stock_report');
		$this->load->view('report-stock', $data);
	}
	/*Stock Report*/
	public function show_stock_report()
	{
		return $this->reports->show_stock_report();
	}
	public function brand_wise_stock()
	{
		return $this->reports->brand_wise_stock();
	}
	public function get_stock_report()
	{
		$data = array(
			'item_wise_report' => $this->show_stock_report(),
			'brand_wise_stock' => $this->brand_wise_stock(),
			//'category_wise_stock' => $this->category_wise_stock(),
		);
		//print_r($data);exit;
		echo json_encode($data);
	}

	//Item Sales Report 
	public function item_sales()
	{
		$this->permission_check('item_sales_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('item_sales_report');
		$this->load->view('report-sales-item', $data);
	}
	public function show_item_sales_report()
	{
		echo $this->reports->show_item_sales_report();
	}
	//Return Item Report 
	public function return_item()
	{
		$this->permission_check('return_items_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('return_items_report');
		$this->load->view('report-return-item', $data);
	}
	public function show_return_items_report()
	{
		echo $this->reports->show_return_items_report();
	}

	//Purchase Payments report
	public function purchase_payments()
	{
		$this->permission_check('purchase_payments_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('purchase_payments_report');
		$this->load->view('report-purchase-payments', $data);
	}
	public function show_purchase_payments_report()
	{
		echo $this->reports->show_purchase_payments_report();
	}

	//Sales Payments report
	public function sales_payments()
	{
		$this->permission_check('sales_payments_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('sales_payments_report');
		$this->load->view('report-sales-payments', $data);
	}
	public function show_sales_payments_report()
	{
		echo $this->reports->show_sales_payments_report();
	}
	//Expired Items Report 
	public function expired_items()
	{
		$this->permission_check('expired_items_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('expired_items_report');
		$this->load->view('report-expired-items', $data);
	}
	public function show_expired_items_report()
	{
		echo $this->reports->show_expired_items_report();
	}
	public function get_profit_loss_report()
	{
		echo json_encode($this->reports->get_profit_loss_report());
	}


	//Item Sales Report 
	public function seller_points()
	{
		$this->permission_check('seller_points_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('seller_points_report');
		$this->load->view('report-seller-points', $data);
	}
	public function show_seller_points_report()
	{
		echo $this->reports->show_seller_points_report();
	}

	//Sales Tax Report 
	public function sales_tax()
	{
		$this->permission_check('sales_tax_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('sales_tax_report');
		$this->load->view('report-sales-tax', $data);
	}
	public function show_sales_tax_report()
	{
		echo $this->reports->show_sales_tax_report();
	}

	//purchase Tax Report 
	public function purchase_tax()
	{
		$this->permission_check('purchase_tax_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('purchase_tax_report');
		$this->load->view('report-purchase-tax', $data);
	}
	public function show_purchase_tax_report()
	{
		echo $this->reports->show_purchase_tax_report();
	}

	//GSTR-1 Report 
	public function gstr_1()
	{
		$this->permission_check('gstr_1_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('gstr_1_report');
		$this->load->view('gst/report-gstr-1', $data);
	}
	public function show_gstr_1_report()
	{
		echo $this->reports->show_gstr_1_report();
	}
	//GSTR-2 Report 
	public function gstr_2()
	{
		$this->permission_check('gstr_2_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('gstr_2_report');
		$this->load->view('gst/report-gstr-2', $data);
	}
	public function show_gstr_2_report()
	{
		echo $this->reports->show_gstr_2_report();
	}

	//Customer Sales Item GST Report 
	public function sales_gst_report()
	{
		$this->permission_check('sales_gst_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('sales_gst_report');
		$this->load->view('gst/report-sales-gst', $data);
	}
	public function show_sales_gst_report()
	{
		echo $this->reports->show_sales_gst_report();
	}
	//Purchase Item GST Report 
	public function purchase_gst_report()
	{
		$this->permission_check('purchase_gst_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('purchase_gst_report');
		$this->load->view('gst/report-purchase-gst', $data);
	}
	public function show_purchase_gst_report()
	{
		echo $this->reports->show_purchase_gst_report();
	}

	//Sales Report 
	public function customer_orders()
	{
		$this->permission_check('customer_orders_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('customer_orders');
		$this->load->view('report-customer-orders', $data);
	}
	public function show_customer_orders()
	{
		echo $this->reports->show_customer_orders();
	}

	//Delivery sheet report
	public function delivery_sheet()
	{
		$this->permission_check('delivery_sheet_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('delivery_sheet_report');
		$this->load->view('report-delivery-sheet', $data);
	}
	public function show_delivery_sheet()
	{
		echo $this->reports->show_delivery_sheet();
	}

	//Load sheet report
	public function load_sheet()
	{
		$this->permission_check('load_sheet_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('load_sheet_report');
		$this->load->view('report-load-sheet', $data);
	}
	public function show_load_sheet()
	{
		echo $this->reports->show_load_sheet();
	}

	//Sales & payments records 
	public function sales_and_payments()
	{
		$this->permission_check('sales_report');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('sales_and_payments_report');
		$this->load->view('report-sales-and-payments', $data);
	}
	public function sales_and_payments_report()
	{
		echo $this->reports->sales_and_payments_report();
	}
}
