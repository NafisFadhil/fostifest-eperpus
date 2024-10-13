import GeneralLayout from "@/Layouts/GeneralLayout";
import { useForm } from "@inertiajs/react";
import React from "react";
import { FaAngleLeft } from "react-icons/fa6";

type Props = {
    loan: any;
};

const Peminjaman = ({ loan }: Props) => {
    const { data, setData, post, processing, errors, reset } = useForm({
        review: "",
        summary: "",
        rating: "",
    });

    const book = loan.code_book.book;

    const handleSubmit = (e: any) => {
        e.preventDefault();

        post("/peminjaman/" + loan.id); // Inertia will post to Laravel route
    };

    return (
        <GeneralLayout>
            <div className="w-full">
                <header className="w-full absolute z-[2] top-0 flex items-center px-4 py-3">
                    {/* Container */}
                    <div className="mx-auto max-w-screen-lg w-full text-center">
                        <div className="flex items-center">
                            {/* Back */}
                            <a
                                href="/"
                                className="hover:opacity-75 transition max-w-max flex items-center bg-white/5 text-white rounded-full px-2 py-1 cursor-pointer"
                            >
                                <FaAngleLeft size={20} className="" />
                                <span className="text-sm">Kembali</span>
                            </a>
                            {/* Title */}
                            {/* <h1 className="text-lg font-bold -mb-1">
                                Detail Buku
                            </h1> */}
                        </div>
                    </div>
                </header>

                {/* Header */}
                <div id="background" className="size-full relative text-white">
                    <div className="absolute -z-[1] size-full bg-primary">
                        <img
                            src={"/" + book.cover || ""}
                            alt=""
                            className="block size-full object-cover object-center opacity-50 blur-lg shadow-inner"
                        />
                    </div>

                    {/* Book Cover */}
                    <div className="size-full flex flex-col justify-center items-center mx-auto lg:max-w-screen-md pt-16 pb-10 px-5 gap-4">
                        {/* Image */}
                        <div className="flex-1 max-w-[220px]">
                            <img
                                src={"/" + book.cover || ""}
                                alt=""
                                className="block w-[180px] h-auto aspect-auto rounded-md shadow-lg shadow-black/50 ml-auto"
                            />
                        </div>
                        {/* Title */}
                        <div className="flex-1 flex flex-col gap-2 text-center leading-4">
                            <span className="max-w-max mx-auto text-xs rounded-md px-1 bg-green-300 text-black">
                                {/* Status : Ready */}
                            </span>
                            <p className="text-lg"> {book.title || ""} </p>
                            <p className="text-sm opacity-75">
                                Di publikasikan pada {book.publish_date || ""}
                            </p>
                            <div className="flex flex-row flex-wrap justify-center items-center gap-2 text-xs">
                                {(book.categories &&
                                    book.categories.length > 0 &&
                                    book.categories.map((cat) => (
                                        <span className="bg-white/10 rounded-full px-4 py-1">
                                            {cat.name || ""}
                                        </span>
                                    ))) || (
                                    <span className="bg-white/10 rounded-full px-4 py-1">
                                        Uncategorized
                                    </span>
                                )}
                            </div>
                        </div>
                    </div>
                </div>

                {/* Content */}
                <main className="relative w-full max-w-screen-lg mx-auto px-4">
                    <div
                        id="content"
                        className="w-full max-w-none prose flex flex-col items-stretch gap-y-4"
                    >
                        {/* Synopsis */}
                        <section className="w-full">
                            <h3 className="">Deskipsi</h3>
                            <ul className="leading-4">
                                <li className="">
                                    Kode Peminjaman : <b>{loan.loan_code}</b>
                                </li>
                                <li className="">
                                    Poin Minimal : <b>{book.min_points}</b>
                                </li>
                                <li className="">
                                    Poin Maksimal : <b>{book.max_points}</b>
                                </li>
                                <li className="">
                                    Hari Peminjaman Maksimal :{" "}
                                    <b>{book.max_borrow_day} hari</b>
                                </li>
                            </ul>
                        </section>

                        {/* Synopsis */}
                        <section className="w-full">
                            <h3 className="">Sinopsis</h3>
                            <p className="">
                                {book.description || "Tidak ada deskripsi"}
                            </p>
                        </section>

                        {/* Rating */}
                        <section className="w-full">
                            <h3 className="">Pengembalian</h3>

                            {loan.status == 1 && (
                                <form
                                    onSubmit={handleSubmit}
                                    className="w-full flex flex-col items-stretch gap-y-3 px-4"
                                >
                                    <div className="relative">
                                        <label
                                            htmlFor="InputRating"
                                            className=""
                                        >
                                            Rating
                                        </label>

                                        <select
                                            name="rating"
                                            id="InputRating"
                                            onChange={(e) => {
                                                console.log(e.target.value);

                                                setData(
                                                    "rating",
                                                    e.target.value
                                                );
                                            }}
                                            className="w-full flex-1 bg-transparent border border-gray-200 rounded-md text-gray-700 focus:ring-0"
                                        >
                                            <option>
                                                {" "}
                                                -- Pilih Rating --{" "}
                                            </option>
                                            <option value="1"> 1 </option>
                                            <option value="2"> 2 </option>
                                            <option value="3"> 3 </option>
                                            <option value="4"> 4 </option>
                                            <option value="5"> 5 </option>
                                        </select>

                                        {errors.rating && (
                                            <div className="text-red-500 text-xs mt-1 ">
                                                {errors.rating}
                                            </div>
                                        )}
                                    </div>

                                    <div className="relative">
                                        <label
                                            htmlFor="InputReview"
                                            className=""
                                        >
                                            Review
                                        </label>

                                        <textarea
                                            name="review"
                                            id="InputReview"
                                            placeholder="Tuliskan review anda untuk buku yang dipinjam..."
                                            rows={5}
                                            onChange={(e) =>
                                                setData(
                                                    "review",
                                                    e.target.value
                                                )
                                            }
                                            className="w-full flex-1 bg-transparent border border-gray-200 rounded-md text-gray-700 focus:ring-0"
                                        ></textarea>

                                        {errors.review && (
                                            <div className="text-red-500 text-xs mt-1 ">
                                                {errors.review}
                                            </div>
                                        )}
                                    </div>

                                    <div className="relative">
                                        <label
                                            htmlFor="InputReview"
                                            className=""
                                        >
                                            Ringkasan
                                        </label>

                                        <textarea
                                            name="summary"
                                            id="InputSummary"
                                            placeholder="Tuliskan ringkasan anda untuk buku yang dipinjam..."
                                            rows={5}
                                            onChange={(e) =>
                                                setData(
                                                    "summary",
                                                    e.target.value
                                                )
                                            }
                                            className="w-full flex-1 bg-transparent border border-gray-200 rounded-md text-gray-700 focus:ring-0"
                                        ></textarea>
                                    </div>

                                    <div className="relative">
                                        <button
                                            type="submit"
                                            className="w-full cursor-pointer py-3 rounded-md shadow-md bg-primary text-white"
                                        >
                                            Kembalikan
                                        </button>
                                    </div>
                                </form>
                            )}

                            {loan.status == 0 && (
                                <p className="">
                                    Silahkan ambil buku di perpustakaan.
                                </p>
                            )}
                        </section>
                    </div>
                </main>
            </div>
        </GeneralLayout>
    );
};

export default Peminjaman;
