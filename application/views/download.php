<?php foreach ($downgallerys as $row):?>
 <?php
         //echo $row->gallery_id;
           $res=explode(",",$row->gallery_id);
           for($i=0;$i<count($res);$i++){
           if($aa = $this->gallery_model->get_gallery_byid($res[$i]))
              {
                //..show pic start
                $where = 'gallery_id = '.$aa->gallery_id.' AND id = '.$fid.' AND is_cover = 0';
                $filers = $this->gallery_model->get_attachments($where);
                if(count($filers) > 0)
                    {
                    foreach ($filers as $frow):
                        // down load
                         $path = site_url('attachments').$frow->path."/";
                         $fname = $frow->real_name;
                         if ($path || $fname)
                         {
                           //echo site_url('attachments').$frow->path."/".$frow->real_name ;
                            $dataf = file_get_contents($path . $fname); // 读文件内容
                            $name = 'semir'.date('Ymd').'.'.$frow->file_type;//
                            force_download($name, $dataf);
                         }else
                         {
                           show_error('下载错误，<b>请确认下载地址和文件</b>！');
                         }
                       // echo $frow->file_type;
                    endforeach


                //....show pic end
                ?>
        <?php
                     }
                     else
                         {
                          show_error('你要下载的文件不存在或你选择的路径有误，请确认你要下载的信息正确！',404);
                         }
                   }
             }
         ?>

<?php endforeach?>
