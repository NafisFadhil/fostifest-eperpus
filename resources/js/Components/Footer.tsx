import React from "react";
import {
    FaBookmark,
    FaCrown,
    FaHouse,
    FaMagnifyingGlass,
    FaUser,
} from "react-icons/fa6";

type Props = {};

const Footer = (props: Props) => {
    return (
        <footer
            className="w-full max-w-[100dvw] px-2 py-2 fixed bottom-0 bg-white z-30"
            style={{ boxShadow: "0 -10px 15px rgb(0 0 0 / 10%)" }}
        >
            <div className="w-full max-w-screen-lg mx-auto flex flex-row justify-stretch items-center">
                <a
                    href="/"
                    className="flex-1 rounded text-black opacity-75 hover:opacity-100 transition"
                >
                    <div className="flex justify-center items-center flex-col text-primary">
                        <FaHouse size={20} className="" />
                        <span className="text-xs font-bold"> Beranda </span>
                    </div>
                </a>
                {/* <a
                    href="/cari"
                    className="flex-1 rounded text-black opacity-75 hover:opacity-100 transition"
                >
                    <div className="flex justify-center items-center flex-col">
                        <FaMagnifyingGlass size={20} className="" />
                        <span className="text-xs font-bold"> Pencarian </span>
                    </div>
                </a> */}
                <a
                    href="/leaderboard"
                    className="flex-1 rounded text-black opacity-75 hover:opacity-100 transition"
                >
                    <div className="flex justify-center items-center flex-col">
                        <FaCrown size={20} className="" />
                        <span className="text-xs font-bold"> Leaderboard </span>
                    </div>
                </a>
                <a
                    href="/mybook"
                    className="flex-1 rounded text-black opacity-75 hover:opacity-100 transition"
                >
                    <div className="flex justify-center items-center flex-col">
                        <FaBookmark size={20} className="" />
                        <span className="text-xs font-bold"> Buku Saya </span>
                    </div>
                </a>
                <a
                    href="/profil"
                    className="flex-1 rounded text-black opacity-75 hover:opacity-100 transition"
                >
                    <div className="flex justify-center items-center flex-col">
                        <FaUser size={20} className="" />
                        <span className="text-xs font-bold"> Profil </span>
                    </div>
                </a>
            </div>
        </footer>
    );
};

export default Footer;
