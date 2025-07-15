import React, { useState, useEffect, useCallback } from "react";
import { useParams, useNavigate, Link } from "react-router-dom";
import axios from "axios";

const KegiatanEdit = () => {
  const { id } = useParams(); // Mengambil ID dari URL
  const navigate = useNavigate();

  const [kegiatanData, setKegiatanData] = useState({
    judul: "",
    deskripsi: "",
    tanggal: "",
    status: "belum"
  });

  const getKegiatan = useCallback(() => {
    axios
      .get(`http://127.0.0.1:8000/api/kegiatans/${id}`) // URL ini sudah benar
      .then((response) => {
        const { judul, deskripsi, tanggal, status } = response.data.data;
        setKegiatanData({ judul, deskripsi, tanggal, status });
      })
      .catch((error) => {
        // Gunakan console.error untuk debugging, hindari alert() untuk error
        console.error("Gagal mengambil data kegiatan:", error);
        alert("Gagal mengambil data kegiatan. Silakan cek konsol browser.");
      });
  }, [id]);

  useEffect(() => {
    getKegiatan();
  }, [getKegiatan]);

  const handleInputChange = (event) => {
    const { name, value } = event.target;
    setKegiatanData((prevState) => ({ ...prevState, [name]: value }));
  };

  const handleSubmit = (event) => {
    event.preventDefault();

    // --- PERBAIKAN ADA DI BARIS INI ---
    // Gunakan ${id} untuk menyisipkan nilai variabel 'id' ke dalam URL
    axios
      .put(`http://localhost:8000/api/kegiatans/${id}`, kegiatanData)
      // ---------------------------------
      .then((response) => {
        alert("Kegiatan berhasil diperbarui!");
        navigate("/kegiatan");
      })
      .catch((error) => {
        console.error("Gagal memperbarui kegiatan:", error);
        // Periksa error.response.data untuk pesan error dari Laravel
        if (error.response && error.response.data && error.response.data.messages) {
          alert("Terjadi kesalahan saat menyimpan perubahan: " + JSON.stringify(error.response.data.messages));
        } else if (error.response && error.response.data && error.response.data.message) {
          alert("Terjadi kesalahan saat menyimpan perubahan: " + error.response.data.message);
        }
        else {
          alert("Terjadi kesalahan saat menyimpan perubahan. Silakan cek konsol browser.");
        }
      });
  };

  return (
    <div className="container-fluid">
      <h1 className="h3 text-gray-800 mb-2">Edit Kegiatan</h1>
      <Link to="/kegiatan" className="btn btn-secondary mb-2">Kembali</Link>

      <div className="card shadow mb-4">
        <div className="card-body">
          <form onSubmit={handleSubmit}>
            <div className="form-group">
              <label>Judul:</label>
              <input
                type="text"
                name="judul"
                value={kegiatanData.judul}
                onChange={handleInputChange}
                className="form-control"
                required
              />
            </div>

            <div className="form-group">
              <label>Deskripsi:</label>
              <textarea
                name="deskripsi"
                value={kegiatanData.deskripsi}
                onChange={handleInputChange}
                className="form-control"
                rows="3"
                required
              ></textarea>
            </div>

            <div className="form-group">
              <label>Tanggal:</label>
              <input
                type="date"
                name="tanggal"
                value={kegiatanData.tanggal}
                onChange={handleInputChange}
                className="form-control"
                required
              />
            </div>

            <div className="form-group">
              <label>Status:</label>
              <select
                name="status"
                value={kegiatanData.status}
                onChange={handleInputChange}
                className="form-control"
              >
                <option value="belum">Belum</option>
                <option value="proses">Proses</option>
                <option value="selesai">Selesai</option>
              </select>
            </div>

            <button type="submit" className="btn btn-primary mt-2">Update</button>
          </form>
        </div>
      </div>
    </div>
  );
};

export default KegiatanEdit;
