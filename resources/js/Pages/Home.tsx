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

export default function Welcome() {
    return (
        <GeneralLayout>
            <Head title="Welcome" />
            <div
                id="wrapper"
                className="w-full relative overflow-x-hidden overflow-y-auto p-4"
            >
                <main className="w-full flex flex-col justify-stretch gap-y-8">
                    {[...Array(5).keys()].map((index) => (
                        <section className="w-full flex flex-col gap-2">
                            <div className="w-full flex items-center">
                                <div className="flex-1 leading-4">
                                    <h2 className="font-bold font-sans">
                                        Rekomendasi Buku
                                    </h2>
                                    <p className="text-sm">
                                        Lorem ipsum dolor sit amet.
                                    </p>
                                </div>
                                <a
                                    href=""
                                    className="text-center text-xs leading-3 text-primary p-2"
                                >
                                    Lihat <br /> Semua
                                </a>
                            </div>
                            <div className="w-full p-2 flex flex-row items-stretch overflow-auto scrollbar-hide justify-start gap-x-3 bg-black/5">
                                {[...Array(12).keys()].map((i) => (
                                    <a
                                        href="/buku"
                                        className="min-w-[120px] hover:grayscale"
                                    >
                                        <div className="w-full h-auto aspect-[3/4] bg-black relative text-yellow-600 rounded-md">
                                            <div className="absolute bottom-0 left-0 bg-white shadow text-xs flex flex-row items-center flex-nowrap leading-3 p-1">
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
