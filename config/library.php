<?php
require_once 'koneksi.php';
class Library extends Koneksi
{
	private $koneksi;

	function __construct()
	{
		$this->koneksi = new Koneksi();
	}

	// Script User
	public function code_generator_user()
	{
		try {
			$sql = "SELECT MAX(id_user) FROM tbl_user";
			$query = $this->koneksi->db->query($sql);
			$data = $query->fetch();

			if ($data) {
				$result = substr($data[0], 4);
				$code = (int) $result;
				$code = $code + 1;
				$generate = "PTG-".str_pad($code, 3, "0", STR_PAD_LEFT);
			} else {
				$generate = "PTG-000";
			}
			return $generate;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function input_user($id_user, $username, $password, $nama_user, $level, $status)
	{
		$id_user = htmlentities($_POST['id_user']);
		$username = htmlentities($_POST['username']);
		$password = password_hash(htmlentities($_POST['password']), PASSWORD_DEFAULT);
		$nama_user = htmlentities($_POST['nama_user']);
		$level = htmlentities($_POST['level']);
		$status = htmlentities($_POST['status']);

		try {
			$sql = "INSERT INTO `tbl_user`(`id_user`, `username`, `password`, `nama_user`, `level`, `status`) VALUES (?,?,?,?,?,?)";
			$query = $this->koneksi->db->prepare($sql);
			$query->bindParam(1, $id_user);
			$query->bindParam(2, $username);
			$query->bindParam(3, $password);
			$query->bindParam(4, $nama_user);
			$query->bindParam(5, $level);
			$query->bindParam(6, $status);
			$query->execute();
			if ($query) {
				return "SUCCESS";
			} else {
				return "FAILED";
			}
		} catch (PDOException $e) {
			if ($e->errorInfo[0] == 23000) {
				return "UNIQUE";
			} else {
				echo $e->getMessage();
				return FALSE;
			}
		}
	}

	public function edit_user($id_user, $nama_user, $level,$status)
	{
		$id_user = htmlentities($_POST['id_user']);
		$nama_user = htmlentities($_POST['nama_user']);
		$level = htmlentities($_POST['level']);
		$status = htmlentities($_POST['status']);
		try {
			$sql = "UPDATE `tbl_user` SET `nama_user`=?,`level`=?,`status`=? WHERE id_user='$id_user'";
			$query = $this->koneksi->db->prepare($sql);
			$query->bindParam(1, $nama_user);
			$query->bindParam(2, $level);
			$query->bindParam(3, $status);
			$query->execute();
			if ($query) {
				return "SUCCESS";
			} else {
				return "FAILED";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function view_user()
	{
		try {
			$sql = "SELECT * FROM tbl_user WHERE level!='Admin Sistem' ORDER BY id_user ASC";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function select_user($id_user)
	{
		try {
			$sql = "SELECT * FROM `tbl_user` WHERE id_user='$id_user'";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function aktifkan_user($id_user)
	{
		try {
			$sql = "UPDATE tbl_user SET status='AKTIF' WHERE id_user='$id_user'";
			$query = $this->koneksi->db->query($sql);
			if ($query) {
				return "SUCCESS";
			} else {
				return "FAILED";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function nonaktifkan_user($id_user)
	{
		try {
			$sql = "UPDATE tbl_user SET status='TIDAK AKTIF' WHERE id_user='$id_user'";
			$query = $this->koneksi->db->query($sql);
			if ($query) {
				return "SUCCESS";
			} else {
				return "FAILED";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function forget_password($id_user, $password)
	{
		$id_user = htmlentities($_POST['id_user']);
		$password = password_hash(htmlentities($_POST['password']), PASSWORD_DEFAULT);

		try {
			$sql = "UPDATE `tbl_user` SET `password`=? WHERE id_user='$id_user'";
			$query = $this->koneksi->db->prepare($sql);
			$query->bindParam(1, $password);
			$query->execute();
			if ($query) {
				return "SUCCESS";
			} else {
				return "FAILED";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function change_password($id_user, $password_baru)
	{
		$id_user = htmlentities($_POST['id_user']);
		$password_lama = htmlentities($_POST['password_lama']);
		$password_baru = password_hash(htmlentities($_POST['password_baru']), PASSWORD_DEFAULT);

		try {
			$sql = "SELECT * FROM tbl_user WHERE id_user='$id_user'";
			$query = $this->koneksi->db->query($sql);
			$data = $query->fetch();

			if (password_verify($password_lama, $data['password'])) {
				$sql = "UPDATE tbl_user SET password=? WHERE id_user='$id_user'";
				$query = $this->koneksi->db->prepare($sql);
				$query->bindParam(1, $password_baru);
				$query->execute();
				return "SUCCESS";
			} else {
				return "NOT SAME";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function jumlah_petugas_pln()
	{
		try {
			$sql = "SELECT COUNT(*) AS jumlah FROM tbl_user WHERE level='Petugas PLN'";
			$query = $this->koneksi->db->query($sql);
			$data = $query->fetch();
			$result = $data['jumlah'];
			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function jumlah_petugas_pembayaran()
	{
		try {
			$sql = "SELECT COUNT(*) AS jumlah FROM tbl_user WHERE level='Petugas Pembayaran'";
			$query = $this->koneksi->db->query($sql);
			$data = $query->fetch();
			$result = $data['jumlah'];
			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	// Script Tarif
	public function code_generator_tarif()
	{
		try {
			$sql = "SELECT MAX(id_tarif) FROM tbl_tarif";
			$query = $this->koneksi->db->query($sql);
			$data = $query->fetch();

			if ($data) {
				$result = substr($data[0], 4);
				$code = (int) $result;
				$code = $code + 1;
				$generate = "TRF-".str_pad($code, 4, "0", STR_PAD_LEFT);
			} else {
				$generate = "TRF-0000";
			}
			return $generate;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function input_tarif($id_tarif, $daya, $tarif_per_kwh, $ppn, $denda)
	{
		$id_tarif = htmlentities($_POST['id_tarif']);
		$daya = htmlentities($_POST['daya']);
		$tarif_per_kwh = htmlentities($_POST['tarif_per_kwh']);
		$ppn = htmlentities($_POST['ppn']);
		$denda = htmlentities($_POST['denda']);

		if ($daya < 1 AND $tarif_per_kwh < 1) {
		
		return "TIDAK VALID";
	}

		try {
			$sql = "INSERT INTO `tbl_tarif`(`id_tarif`, `daya`, `tarif_per_kwh`, `ppn`, `denda`) VALUES (?,?,?,?,?)";
			$query = $this->koneksi->db->prepare($sql);
			$query->bindParam(1, $id_tarif);
			$query->bindParam(2, $daya);
			$query->bindParam(3, $tarif_per_kwh);
			$query->bindParam(4, $ppn);
			$query->bindParam(5, $denda);
			$query->execute();
			if ($query) {
				return "SUCCESS";
			} else {
				return "FAILED";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function edit_tarif($id_tarif, $daya, $tarif_per_kwh, $ppn, $denda)
	{
		$id_tarif = htmlentities($_POST['id_tarif']);
		$daya = htmlentities($_POST['daya']);
		$tarif_per_kwh = htmlentities($_POST['tarif_per_kwh']);
		$ppn = htmlentities($_POST['ppn']);
		$denda = htmlentities($_POST['denda']);

		try {
			$sql = "UPDATE `tbl_tarif` SET `daya`=?,`tarif_per_kwh`=?,`ppn`=?,`denda`=? WHERE id_tarif='$id_tarif'";
			$query = $this->koneksi->db->prepare($sql);
			$query->bindParam(1, $daya);
			$query->bindParam(2, $tarif_per_kwh);
			$query->bindParam(3, $ppn);
			$query->bindParam(4, $denda);
			$query->execute();
			if ($query) {
				return "SUCCESS";
			} else {
				return "FAILED";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function view_tarif()
	{
		try {
			$sql = "SELECT * FROM tbl_tarif ORDER BY id_tarif ASC";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function select_tarif($id_tarif)
	{
		try {
			$sql = "SELECT * FROM `tbl_tarif` WHERE id_tarif='$id_tarif'";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function delete_tarif($id_tarif)
	{
		try {
			$sql = "DELETE FROM `tbl_tarif` WHERE id_tarif='$id_tarif'";
			$query = $this->koneksi->db->query($sql);
			if ($query) {
				return "SUCCESS";
			} else {
				return "FAILED";
			}
		} catch (PDOException $e) {
			return FALSE;
		}
	}

	public function jumlah_tarif()
	{
		try {
			$sql = "SELECT COUNT(*) AS jumlah FROM tbl_tarif";
			$query = $this->koneksi->db->query($sql);
			$data = $query->fetch();
			$result = $data['jumlah'];
			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	// Script Kota
	public function code_generator_kota()
	{
		try {
			$sql = "SELECT MAX(id_kota) FROM tbl_kota";
			$query = $this->koneksi->db->query($sql);
			$data = $query->fetch();

			if ($data) {
				$result = $data[0];
				$code = (int) $result;
				$generate = $code + 1;
			} else {
				$generate = 0;
			}
			return $generate;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function input_kota($id_kota, $nama_kota, $ppju)
	{
		$id_kota = htmlentities($_POST['id_kota']);
		$nama_kota = htmlentities($_POST['nama_kota']);
		$ppju = htmlentities($_POST['ppju']);

		try {
			$sql = "INSERT INTO `tbl_kota`(`id_kota`, `nama_kota`, `ppju`) VALUES (?,?,?)";
			$query = $this->koneksi->db->prepare($sql);
			$query->bindParam(1, $id_kota);
			$query->bindParam(2, $nama_kota);
			$query->bindParam(3, $ppju);
			$query->execute();
			if ($query) {
				return "SUCCESS";
			} else {
				return "FAILED";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function edit_kota($id_kota, $nama_kota, $ppju)
	{
		$id_kota = htmlentities($_POST['id_kota']);
		$nama_kota = htmlentities($_POST['nama_kota']);
		$ppju = htmlentities($_POST['ppju']);

		try {
			$sql = "UPDATE `tbl_kota` SET `nama_kota`=?,`ppju`=? WHERE id_kota='$id_kota'";
			$query = $this->koneksi->db->prepare($sql);
			$query->bindParam(1, $nama_kota);
			$query->bindParam(2, $ppju);
			$query->execute();
			if ($query) {
				return "SUCCESS";
			} else {
				return "FAILED";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function view_kota()
	{
		try {
			$sql = "SELECT * FROM tbl_kota ORDER BY id_kota ASC";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function select_kota($id_kota)
	{
		try {
			$sql = "SELECT * FROM `tbl_kota` WHERE id_kota='$id_kota'";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function delete_kota($id_kota)
	{
		try {
			$sql = "DELETE FROM `tbl_kota` WHERE id_kota='$id_kota'";
			$query = $this->koneksi->db->query($sql);
			if ($query) {
				return "SUCCESS";
			} else {
				return "FAILED";
			}
		} catch (PDOException $e) {
			return FALSE;
		}
	}

	public function jumlah_kota()
	{
		try {
			$sql = "SELECT COUNT(*) AS jumlah FROM tbl_kota";
			$query = $this->koneksi->db->query($sql);
			$data = $query->fetch();
			$result = $data['jumlah'];
			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	// Script Pelanggan
	public function code_generator_pelanggan()
	{
		try {
			$sql = "SELECT MAX(id_pelanggan) FROM tbl_pelanggan";
			$query = $this->koneksi->db->query($sql);
			$data = $query->fetch();

			if ($data) {
				$result = substr($data[0], 4);
				$code = (int) $result;
				$code = $code + 1;
				$generate = "PLG-".str_pad($code, 4, "0", STR_PAD_LEFT);
			} else {
				$generate = "PLG-0000";
			}
			return $generate;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function input_pelanggan($id_pelanggan, $id_tarif, $id_kota, $nometer, $nama_pelanggan, $alamat)
	{
		$id_pelanggan = htmlentities($_POST['id_pelanggan']);
		$id_tarif = htmlentities($_POST['id_tarif']);
		$id_kota = htmlentities($_POST['id_kota']);
		$nometer = htmlentities($_POST['nometer']);
		$nama_pelanggan = htmlentities($_POST['nama_pelanggan']);
		$alamat = htmlentities($_POST['alamat']);

		try {
			$sql = "INSERT INTO `tbl_pelanggan`(`id_pelanggan`, `id_tarif`, `id_kota`, `nometer`, `nama_pelanggan`, `alamat`) VALUES (?,?,?,?,?,?)";
			$query = $this->koneksi->db->prepare($sql);
			$query->bindParam(1, $id_pelanggan);
			$query->bindParam(2, $id_tarif);
			$query->bindParam(3, $id_kota);
			$query->bindParam(4, $nometer);
			$query->bindParam(5, $nama_pelanggan);
			$query->bindParam(6, $alamat);
			$query->execute();
			if ($query) {
				return "SUCCESS";
			} else {
				return "FAILED";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function edit_pelanggan($id_pelanggan, $id_tarif, $id_kota, $nometer, $nama_pelanggan, $alamat)
	{
		$id_pelanggan = htmlentities($_POST['id_pelanggan']);
		$id_tarif = htmlentities($_POST['id_tarif']);
		$id_kota = htmlentities($_POST['id_kota']);
		$nometer = htmlentities($_POST['nometer']);
		$nama_pelanggan = htmlentities($_POST['nama_pelanggan']);
		$alamat = htmlentities($_POST['alamat']);

		try {
			$sql = "UPDATE `tbl_pelanggan` SET `id_tarif`=?,`id_kota`=?,`nometer`=?,`nama_pelanggan`=?,`alamat`=? WHERE id_pelanggan='$id_pelanggan'";
			$query = $this->koneksi->db->prepare($sql);
			$query->bindParam(1, $id_tarif);
			$query->bindParam(2, $id_kota);
			$query->bindParam(3, $nometer);
			$query->bindParam(4, $nama_pelanggan);
			$query->bindParam(5, $alamat);
			$query->execute();
			if ($query) {
				return "SUCCESS";
			} else {
				return "FAILED";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function view_pelanggan()
	{
		try {
			$sql = "SELECT * FROM v_pelanggan ORDER BY id_pelanggan ASC";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function select_pelanggan($id_pelanggan)
	{
		try {
			$sql = "SELECT * FROM `tbl_pelanggan` WHERE id_pelanggan='$id_pelanggan'";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function select_v_pelanggan($id_pelanggan)
	{
		try {
			$sql = "SELECT * FROM `v_pelanggan` WHERE id_pelanggan='$id_pelanggan'";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function select_penggunaan_pelanggan($id_pelanggan)
	{
		try {
			$sql = "SELECT * FROM `v_penggunaan` WHERE id_pelanggan='$id_pelanggan'";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function select_tagihan_pelanggan($id_pelanggan)
	{
		try {
			$sql = "SELECT * FROM `v_tagihan` WHERE id_pelanggan='$id_pelanggan'";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function select_tagihan_pembayaran($id_tagihan)
	{
		try {
			$sql = "SELECT * FROM `v_tagihan` WHERE id_tagihan='$id_tagihan'";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function jumlah_pelanggan()
	{
		try {
			$sql = "SELECT COUNT(*) AS jumlah FROM v_pelanggan";
			$query = $this->koneksi->db->query($sql);
			$data = $query->fetch();
			$result = $data['jumlah'];
			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	// Script Penggunaan
	public function code_generator_penggunaan()
	{
		try {
			$sql = "SELECT MAX(id_penggunaan) FROM tbl_penggunaan";
			$query = $this->koneksi->db->query($sql);
			$data = $query->fetch();

			if ($data) {
				$result = substr($data[0], 4);
				$code = (int) $result;
				$code = $code + 1;
				$generate = "PGN-".str_pad($code, 4, "0", STR_PAD_LEFT);
			} else {
				$generate = "PGN-0000";
			}
			return $generate;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function input_penggunaan($id_penggunaan, $id_pelanggan, $bulan, $tahun, $meter_awal, $meter_akhir)
	{
		$id_penggunaan = htmlentities($_POST['id_penggunaan']);
		$id_pelanggan = htmlentities($_POST['id_pelanggan']);
		$bulan = htmlentities($_POST['bulan']);
		$tahun = htmlentities($_POST['tahun']);
		$meter_awal = htmlentities($_POST['meter_awal']);
		$meter_akhir = htmlentities($_POST['meter_akhir']);

		try {
			$sql = "INSERT INTO `tbl_penggunaan`(`id_penggunaan`, `id_pelanggan`, `bulan`, `tahun`, `meter_awal`, `meter_akhir`) VALUES (?,?,?,?,?,?)";
			$query = $this->koneksi->db->prepare($sql);
			$query->bindParam(1, $id_penggunaan);
			$query->bindParam(2, $id_pelanggan);
			$query->bindParam(3, $bulan);
			$query->bindParam(4, $tahun);
			$query->bindParam(5, $meter_awal);
			$query->bindParam(6, $meter_akhir);
			$query->execute();
			if ($query) {
				return "SUCCESS";
			} else {
				return "FAILED";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function view_penggunaan()
	{
		try {
			$sql = "SELECT * FROM v_penggunaan ORDER BY id_penggunaan ASC";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function select_penggunaan($id_penggunaan)
	{
		try {
			$sql = "SELECT * FROM `v_penggunaan` WHERE id_penggunaan='$id_penggunaan'";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	// Script Biaya Admin
	public function view_biaya_admin()
	{
		try {
			$sql = "SELECT * FROM `tbl_biaya_admin`";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function select_biaya_admin($id_biaya_admin)
	{
		try {
			$sql = "SELECT * FROM `tbl_biaya_admin` WHERE id_biaya_admin='$id_biaya_admin'";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}
	
	public function edit_biaya_admin($id_biaya_admin, $biaya_admin)
	{
		$id_biaya_admin = htmlentities($_POST['id_biaya_admin']);
		$biaya_admin = htmlentities($_POST['biaya_admin']);

		try {
			$sql = "UPDATE `tbl_biaya_admin` SET `biaya_admin`=? WHERE id_biaya_admin='$id_biaya_admin'";
			$query = $this->koneksi->db->prepare($sql);
			$query->bindParam(1, $biaya_admin);
			$query->execute();
			if ($query) {
				return "SUCCESS";
			} else {
				return "FAILED";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function jumlah_biaya_admin()
	{
		try {
			$sql = "SELECT SUM(biaya_admin) AS jumlah FROM tbl_biaya_admin";
			$query = $this->koneksi->db->query($sql);
			$data = $query->fetch();
			$result = $data['jumlah'];
			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	// Script Pembayaran
	public function code_generator_pembayaran()
	{
		try {
			$sql = "SELECT MAX(id_pembayaran) FROM tbl_pembayaran";
			$query = $this->koneksi->db->query($sql);
			$data = $query->fetch();

			if ($data) {
				$result = substr($data[0], 8);
				$code = (int) $result;
				$code = $code + 1;
				$generate = "PT".date("ymd")."".$code;
			} else {
				$generate = "PT0000000000000";
			}
			return $generate;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function input_pembayaran($id_pembayaran, $id_pelanggan, $id_tagihan, $id_biaya_admin, $id_user, $tgl_pembayaran, $biaya_denda, $biaya_admin, $jumlah_biaya)
	{
		$id_pembayaran = htmlentities($_POST['id_pembayaran']);
		$id_pelanggan = htmlentities($_POST['id_pelanggan']);
		$id_tagihan = htmlentities($_POST['id_tagihan']);
		$id_biaya_admin = htmlentities($_POST['id_biaya_admin']);
		$id_user = htmlentities($_POST['id_user']);
		$tgl_pembayaran = htmlentities($_POST['tgl_pembayaran']);
		$biaya_denda = htmlentities($_POST['biaya_denda']);
		$biaya_admin = htmlentities($_POST['biaya_admin']);
		$jumlah_biaya = htmlentities($_POST['jumlah_biaya']);

		try {
			$sql = "INSERT INTO `tbl_pembayaran`(`id_pembayaran`, `id_pelanggan`, `id_tagihan`, `id_biaya_admin`, `id_user`, `tgl_pembayaran`, `biaya_denda`, `biaya_admin`, `jumlah_biaya`) VALUES (?,?,?,?,?,?,?,?,?)";
			$query = $this->koneksi->db->prepare($sql);
			$query->bindParam(1, $id_pembayaran);
			$query->bindParam(2, $id_pelanggan);
			$query->bindParam(3, $id_tagihan);
			$query->bindParam(4, $id_biaya_admin);
			$query->bindParam(5, $id_user);
			$query->bindParam(6, $tgl_pembayaran);
			$query->bindParam(7, $biaya_denda);
			$query->bindParam(8, $biaya_admin);
			$query->bindParam(9, $jumlah_biaya);
			$query->execute();
			if ($query) {
				return "SUCCESS";
			} else {
				return "FAILED";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function select_print_pembayaran($id_tagihan)
	{
		try {
			$sql = "SELECT * FROM `v_hasil_pembayaran` WHERE id_tagihan='$id_tagihan'";
			$query = $this->koneksi->db->query($sql);
			return $query;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}

	public function jumlah_pembayaran()
	{
		try {
			$sql = "SELECT COUNT(*) AS jumlah FROM tbl_pembayaran";
			$query = $this->koneksi->db->query($sql);
			$data = $query->fetch();
			$result = $data['jumlah'];
			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return FALSE;
		}
	}
	
}
?>
