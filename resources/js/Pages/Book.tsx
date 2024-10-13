import GeneralLayout from "@/Layouts/GeneralLayout";
import SubPageLayout from "@/Layouts/SubPageLayout";
import { useForm } from "@inertiajs/react";
import React, { useEffect, useState } from "react";
import { FaAngleLeft, FaStar } from "react-icons/fa6";

type Props = {
    book: object;
};

const Book = ({ book }: Props) => {
    const [hasReview, setHasReview] = useState(false);

    useEffect(() => {
        // console.log(book);
        // return () => {
        //     // null;
        // };
    }, []);

    const submit: FormEventHandler = (e: any) => {
        e.preventDefault();

        post(route("book"));
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
                            <h3 className="">Rating dan ulasan</h3>
                            <div className="w-full flex justify-stretch items-stretch overflow-x-scroll scrollbar-hide gap-x-4">
                                {book.codes &&
                                    book.codes.map(
                                        (item: object, i: number) => {
                                            // console.log(
                                            //     item.loan,
                                            //     item.loan.length
                                            // );

                                            if (
                                                !item.loan ||
                                                item.loan.length < 1
                                            ) {
                                                return null;
                                            }

                                            return item.loan.map(
                                                (loan: object, i: number) => {
                                                    if (!loan.review) {
                                                        return null;
                                                    }

                                                    useEffect(() => {
                                                        setHasReview(true);
                                                    });

                                                    return (
                                                        loan.review && (
                                                            <div
                                                                key={i}
                                                                className="w-full max-w-[300px] flex-shrink-0 flex flex-col bg-white border rounded-lg shadow-md p-4"
                                                            >
                                                                {/* Testimonial Profile */}
                                                                <div className="w-full">
                                                                    <p className="font-bold m-0">
                                                                        {
                                                                            loan
                                                                                .user
                                                                                .name
                                                                        }
                                                                    </p>
                                                                    {/* Star */}
                                                                </div>

                                                                {/* Testimonial Desc */}
                                                                <p className="text-sm">
                                                                    {loan.review ||
                                                                        "Tidak ada ulasan"}
                                                                </p>
                                                            </div>
                                                        )
                                                    );
                                                }
                                            );
                                        }
                                    )}
                            </div>
                            {!hasReview && (
                                <div className="w-full flex flex-col p-4">
                                    <p className="text-sm">Belum ada ulasan</p>
                                </div>
                            )}
                        </section>

                        <section className="w-full py-4">
                            <h3 className="">Daftar Buku</h3>
                            <table className="w-full">
                                <thead>
                                    <tr>
                                        <th> No </th>
                                        <th> Kode Buku </th>
                                        <th> Status </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {book.codes.map(
                                        (item: object, i: number) => {
                                            return (
                                                <tr key={i}>
                                                    <td className="text-center">
                                                        {i + 1}
                                                    </td>
                                                    <td className="text-center">
                                                        {item.code}
                                                    </td>
                                                    <td className="text-center">
                                                        {item.status == 0
                                                            ? "Tidak tersedia"
                                                            : "Ready"}
                                                    </td>
                                                    <td className="text-center">
                                                        {(item.status == 1 && (
                                                            <a
                                                                href={
                                                                    "/checkout/" +
                                                                    item.id
                                                                }
                                                                className="block w-full rounded-full shadow px-4 py-2 text-center bg-primary text-white not-prose hover:opacity-75 transition"
                                                            >
                                                                Pinjam Sekarang
                                                            </a>
                                                        )) || (
                                                            <span className="text-xs rounded-md px-1 bg-red-300 text-white">
                                                                Buku tidak
                                                                tersedia
                                                            </span>
                                                        )}
                                                    </td>
                                                </tr>
                                            );
                                        }
                                    )}
                                </tbody>
                            </table>
                            {/* <a
                                href={"/checkout/" + book.id}
                                className="block w-full rounded-full shadow px-4 py-2 text-center bg-primary text-white not-prose hover:opacity-75 transition"
                            >
                                Pinjam Sekarang
                            </a> */}
                        </section>
                    </div>
                </main>
            </div>
        </GeneralLayout>
    );
};

export default Book;
