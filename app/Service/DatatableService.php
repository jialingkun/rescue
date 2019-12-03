<?php namespace App\Service;
use Yajra\Datatables\Datatables;
class DataTableService {

	public function generate($data, $action = 'true'){

		if( $action == 'editonly'){
			return Datatables::of($data)->addColumn('action', function ($data) {
	                return '<center>
	                		<a data-toggle="modal" href="#modal-edit" onClick="prepareEdit('.$data->id.');loaddata('.$data->id.');" class="btn btn-xs btn-info	"><i class="fa fa-edit"></i>
	                		</a> 
	                </center>';
				})->escapeColumns(['action'])->make();	

		}

		if( $action == 'editonlyPengaduan'){
			return Datatables::of($data)->addColumn('action', function ($data) {
	                return '<center>
	                		<a data-toggle="modal" href="#modal-edit" onClick="prepareEdit('.$data->id.');loaddata('.$data->id.');" class="btn btn-xs btn-info	"><i class="fa fa-edit"></i>
	                		</a> 
	                </center>';
				})->addColumn('pesan', function ($data) {

	                return substr($data->pesan, 0, 50)." ....";
				})->escapeColumns(['action'])->make();	

		}

		if( $action == 'editonlyTransaksi'){
			return Datatables::of($data)->addColumn('action', function ($data) {
	                return '<center>
	                		<a data-toggle="modal" href="#modal-edit" onClick="prepareEdit('.$data->id_transaksi.');loaddata('.$data->id_transaksi.');" class="btn btn-xs btn-info	"><i class="fa fa-edit"></i>
	                		</a> 
	                </center>';
				})->escapeColumns(['action'])->make();	

		}
		
		if( $action == 'viewDetail'){
			return Datatables::of($data)->addColumn('action', function ($data) {
	                return '<center>
							<a onClick="viewDetail('.$data->id_transaksi.');" class="btn btn-xs btn-warning	"><i class="fa fa-map-marker"></i>
							</a> 
	                		<a data-toggle="modal" href="#modal-edit" onClick="prepareEdit('.$data->id_transaksi.');loaddata('.$data->id_transaksi.');" class="btn btn-xs btn-info	"><i class="fa fa-phone"></i>
	                		</a> 
	                </center>';
				})->escapeColumns(['action'])->make();	

		}

		if( $action == 'readonly'){
			
			return Datatables::of($data)->addColumn('action', function ($data) {

	                return '
	                	<center>
	                		<a data-toggle="modal" href="#modal-edit" onClick="prepareEdit('.$data->id.');loaddata('.$data->id.');" class="btn btn-xs btn-info"><i class="fa fa-info"></i>
	                		</a> 
	                </center>';
				})->removeColumn('id')->editColumn('id', 'ID: @{{$id}}')
                ->escapeColumns(['action'])->make();

        }
		if( $action == 'gotodetail'){
			
			return Datatables::of($data)->addColumn('action', function ($data) {

	                return '
	                	<center>
	                		<a data-toggle="modal" onClick="gotoDetail('.$data->id_transaksi.');loaddata('.$data->id_transaksi.');" class="btn btn-xs btn-info"><i class="fa fa-info"></i>
	                		</a> 
	                </center>';
				})->editColumn('id', 'ID: @{{$id}}')->make();

		}
		if( $action == 'nodelete'){
			
			return Datatables::of($data)->addColumn('action', function ($data) {

	                return '
	                	<center>
	                		<a data-toggle="modal" onClick="gotoDetail('.$data->id.');" class="btn btn-xs btn-info"><i class="fa fa-list"></i>
	                		</a> 
	                		<a data-toggle="modal" href="#modal-edit" onClick="prepareEdit('.$data->id.');loaddata('.$data->id.');" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
	                		</a> 
		                </center>';
				})->escapeColumns(['action'])->make();	

		}
		if( $action == 'nodeletedatainformasi'){
			
			return Datatables::of($data)->addColumn('action', function ($data) {

	                return '
	                	<center>
	                		<a data-toggle="modal" onClick="gotoDetail('.$data->id.');" class="btn btn-xs btn-info"><i class="fa fa-list"></i>
	                		</a> 
	                		<a data-toggle="modal" href="#modal-edit" onClick="prepareEdit('.$data->id.');loaddata('.$data->id.');" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
	                		</a> 
		                </center>';
				})
				->addColumn('data', function ($data) {

	                return substr($data->data, 0, 50)." ....";
				})->escapeColumns(['action'])->make();	

		}
		if( $action == 'nodetail'){
			
			return Datatables::of($data)->addColumn('action', function ($data) {

	                return '
	                	<center>
	                		<a data-toggle="modal" href="#modal-edit" onClick="prepareEdit('.$data->id.');loaddata('.$data->id.');" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
	                		</a> 
	                		<a onClick="deleteData('.$data->id.')" class="btn btn-xs btn-danger" id="delete"><i class="fa fa-trash-o"></i></a>
		                </center>';
				})->escapeColumns(['action'])->make();	

		}
		if( $action == 'nodetailrelasi'){
			return Datatables::of($data)
			->addColumn('action', function ($data) {

	                return '
	                	<center>
	                		<a data-toggle="modal" href="#modal-edit" onClick="prepareEdit('.$data->id.');loaddata('.$data->id.');" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
	                		</a> 
	                		<a onClick="deleteData('.$data->id.')" class="btn btn-xs btn-danger" id="delete"><i class="fa fa-trash-o"></i></a>
		                </center>';
				})
			->editColumn('path', function ($data) {

	                return '<img src='.url($data->path).' style="width:100px">';
				})
			->escapeColumns(['action'])->make();	

		}
		if( $action == 'full'){
			
			return Datatables::of($data)->addColumn('action', function ($data) {

	                return '
	                	<center>
	                		<a data-toggle="modal" href="#modal-edit" onClick="prepareEdit('.$data->id.');loaddata('.$data->id.');" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
	                		</a> 
	                		<a data-toggle="modal" onClick="gotoDetail('.$data->id.');loaddata('.$data->id.');" class="btn btn-xs btn-info"><i class="fa fa-list"></i>
	                		</a> 
	                		<a onClick="deleteData('.$data->id.')" class="btn btn-xs btn-danger" id="delete"><i class="fa fa-trash-o"></i></a>
		                </center>';
				})->escapeColumns(['action'])->make();	

		}
		if( $action == 'noaction'){
			
			return Datatables::of($data)->make();	

		}
        if( $action == 'delegasi'){
            return Datatables::of($data)
                ->addColumn('action', function ($data) {

                    return '
	                	<center>
	                		<a data-toggle="modal" onClick="gotoDetail('.$data->id.');" class="btn btn-xs btn-info"><i class="fa fa-comments"></i>
	                		</a> 
	                		<a data-toggle="modal" href="#modal-edit" onClick="prepareEditIn('.$data->id.','.$data->id_admin.');loaddata('.$data->id.','.$data->id_admin.');" class="btn btn-xs btn-success"><i class="fa fa-edit"></i>
	                		</a>
	                		<a data-toggle="modal" onClick="gotoDetailPengaduan('.$data->id.');" class="btn btn-xs btn-warning"><i class="fa fa-map"></i>
	                		</a> 
		                </center>';
                })
                ->editColumn('path', function ($data) {

                    return '<img src='.url($data->path).' style="width:100px">';
                })
                ->removeColumn('id_admin','latitude','longitude','lokasi')
                ->escapeColumns(['action'])->make();
        }
        if( $action == 'delegasi-admin'){
            return Datatables::of($data)
                ->addColumn('action', function ($data) {

                    return '
	                	<center>
	                		<a data-toggle="modal" onClick="gotoDetail('.$data->id.');" class="btn btn-xs btn-info"><i class="fa fa-comments"></i>
	                		</a> 
		                </center>';
                })
                ->editColumn('path', function ($data) {

                    return '<img src='.url($data->path).' style="width:100px">';
                })
                ->removeColumn('id_admin','latitude','longitude','lokasi')
                ->escapeColumns(['action'])->make();
        }
        if( $action == 'readonly-darurat'){

            return Datatables::of($data)
                ->addColumn('action', function ($data) {

                return '<center>
	                	<a data-toggle="modal" onClick="gotoDetail('.$data->id.');" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i>
	                		</a>
	                	</center> ';
            })
                ->setRowClass(function ($data) {
                    return $data->flag == 1 ? 'alert-success' : '';
                })
                ->editColumn('path', function ($data) {
                    return '<img src='.url($data->path).' style="width:100px">';
                })
                ->removeColumn('id')->editColumn('id', 'ID: @{{$id}}')
                ->removeColumn('flag')
                ->escapeColumns(['action'])->make();

        }



    }
}