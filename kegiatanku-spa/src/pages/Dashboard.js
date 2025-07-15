import React, { useEffect, useState } from "react";
import axios from "axios";

const Dashboard = () => {
  const [total, setTotal] = useState(0);
  const [selesai, setSelesai] = useState(0);
  const [rencanaList, setRencanaList] = useState([]);
  const [sisaRencana, setSisaRencana] = useState(0);

  useEffect(() => {
    axios.get("http://localhost:8000/api/kegiatans").then((res) => {
      const data = res.data.data;
      setTotal(data.length);
      setSelesai(data.filter((item) => item.status === "selesai").length);

      const belumSelesaiList = data.filter((item) => item.status !== "selesai");
      setSisaRencana(belumSelesaiList.length > 3 ? belumSelesaiList.length - 3 : 0);
      setRencanaList(belumSelesaiList.slice(0, 3));
    });
  }, []);

  const progress = total > 0 ? Math.round((selesai / total) * 100) : 0;
  const belumSelesai = total - selesai;

  return (
    <div className="container-fluid">
      {/* Heading */}
      <div className="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 className="h4 mb-0 text-dark">
          Hai 👋, kamu punya {belumSelesai} kegiatan belum selesai hari ini.
        </h1>
      </div>

      {/* Card */}
      <div className="row">
        {/* Rencana Hari Ini */}
        <div className="col-xl-6 col-md-6 mb-4">
          <div
            className="card shadow h-100 py-2"
            style={{ borderLeft: "5px solid #f8bbd0", backgroundColor: "#fce4ec" }}
          >
            <div className="card-body">
              <div className="row no-gutters align-items-center">
                <div className="col mr-2">
                  <div
                    className="text-xs font-weight-bold text-uppercase mb-1"
                    style={{ color: "#d81b60" }}
                  >
                    Rencana Hari Ini
                  </div>
                  {rencanaList.length === 0 ? (
                    <div className="h5 mb-0 font-weight-bold" style={{ color: "#880e4f" }}>
                      Belum ada kegiatan
                    </div>
                  ) : (
                    <>
                      <ul className="mb-0 pl-3" style={{ color: "#880e4f" }}>
                        {rencanaList.map((item) => (
                          <li key={item.id} className="h6 mb-1">
                            {item.judul}
                          </li>
                        ))}
                      </ul>
                      {sisaRencana > 0 && (
                        <small className="text-muted pl-3">
                          dan {sisaRencana} kegiatan lainnya...
                        </small>
                      )}
                    </>
                  )}
                </div>
                <div className="col-auto">
                  <i className="fas fa-calendar fa-2x" style={{ color: "#f48fb1" }}></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Progress */}
        <div className="col-xl-6 col-md-6 mb-4">
          <div
            className="card shadow h-100 py-2"
            style={{ borderLeft: "5px solid #f48fb1", backgroundColor: "#fce4ec" }}
          >
            <div className="card-body">
              <div className="row no-gutters align-items-center">
                <div className="col mr-2">
                  <div
                    className="text-xs font-weight-bold text-uppercase mb-1"
                    style={{ color: "#ad1457" }}
                  >
                    Progress
                  </div>
                  <div className="h5 mb-0 font-weight-bold" style={{ color: "#6a1b9a" }}>
                    {progress}% Tercapai
                  </div>
                </div>
                <div className="col-auto">
                  <i className="fas fa-check-circle fa-2x" style={{ color: "#f48fb1" }}></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Dashboard;
