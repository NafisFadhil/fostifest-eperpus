import { Link, Head } from "@inertiajs/react";
import { PageProps } from "@/types";
import {
    FaMagnifyingGlass,
    FaStar,
    FaHouse,
    FaUser,
    FaBookmark,
} from "react-icons/fa6";
import GeneralLayout from "@/Layouts/GeneralLayout";
import HeaderHomePage from "@/Components/HeaderHomePage";
import Footer from "@/Components/Footer";

export default function Home() {
    return (
        <GeneralLayout>
            <Head title="Home" />

            <div
                id="wrapper"
                className="w-full relative overflow-x-hidden overflow-y-auto"
            >
                <HeaderHomePage />

                <div className="w-full px-4 pt-16 pb-10 text-center prose prose-invert prose-lg max-w-none bg-primary">
                    <h2 className=""> Selamat Datang </h2>
                </div>

                <main className="w-full flex flex-col justify-stretch gap-y-8 px-4 py-8">
                    {[...Array(3).keys()].map((index) => (
                        <section className="w-full max-w-screen-lg mx-auto flex flex-col gap-2">
                            <div className="w-full flex items-center">
                                <div className="flex-1 leading-5">
                                    <h2 className="font-bold font-sans">
                                        Rekomendasi Buku
                                    </h2>
                                    <p className="text-sm">
                                        Lorem ipsum dolor sit amet.
                                    </p>
                                </div>
                                <a
                                    href=""
                                    className="text-center text-xs leading-3 text-primary font-bold hover:bg-black/5 rounded-full p-2 transition"
                                >
                                    Lihat <br /> Semua
                                </a>
                            </div>
                            <div className="w-full p-2 border-8 border-[#EEE] flex flex-row items-stretch overflow-auto scrollbar-hide rounded shadow justify-start gap-x-3 bg-[#EEE]">
                                {[...Array(12).keys()].map((i) => (
                                    <a
                                        href={"/detail/" + i}
                                        className="min-w-[150px] hover:scale-105 transition-all"
                                    >
                                        <div className="w-full max-w-[220px] h-auto relative rounded-md">
                                            {/* Image */}
                                            <img
                                                src="/asset/images/cover-buku.jpeg"
                                                alt=""
                                                className="block w-[180px] h-auto rounded-md ml-auto aspect-[3/4] object-cover object-center overflow-hidden"
                                            />

                                            <div className="absolute bottom-0 left-0 bg-white shadow text-xs flex flex-row items-center flex-nowrap leading-3 p-1 text-yellow-600">
                                                <FaStar
                                                    size={10}
                                                    className="p-0 m-0"
                                                />
                                                <span> 4.8 </span>
                                            </div>
                                        </div>
                                        <div className="py-2">
                                            <p className="text-xs leading-4">
                                                Judul Buku: Harry Potter X
                                                Series
                                            </p>
                                        </div>
                                    </a>
                                ))}
                            </div>
                        </section>
                    ))}
                </main>
            </div>
        </GeneralLayout>
    );
}
