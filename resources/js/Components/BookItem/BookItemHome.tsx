import React, { useEffect } from "react";

type Props = {
    data: object;
};

const BookItemHome = ({ data }: Props) => {
    useEffect(() => {
        console.log(data);

        return () => {
            null;
        };
    }, []);

    return (
        <a
            href={"/detail/" + data.id}
            className="flex-1 flex-shrink flex-grow-0 basis-[150px] hover:scale-105 transition-all"
        >
            <div className="w-full h-auto relative rounded-md">
                {/* Image */}
                <img
                    src={"/" + data.cover || ""}
                    alt=""
                    className="block w-full h-auto rounded-md ml-auto aspect-[3/4] object-cover object-center overflow-hidden"
                />

                {/* <div className="absolute bottom-0 left-0 bg-white shadow text-xs flex flex-row items-center flex-nowrap leading-3 p-1 text-yellow-500 gap-1">
                    <FaStar size={10} className="p-0 m-0" />
                    <span className="-mb-1"> 5 </span>
                </div> */}
            </div>
            <div className="pb-2 pt-0">
                <p className="text-sm leading-4">{data.title}</p>
                <p className="text-xs text-yellow-600">
                    {" "}
                    {data.min_points} - {data.max_points} points{" "}
                </p>
            </div>
        </a>
    );
};

export default BookItemHome;
