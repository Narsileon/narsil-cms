import { Bullet } from "@narsil-cms/components/bullet";
import { cn } from "@narsil-cms/lib/utils";
import type { Model } from "@narsil-cms/types";
import { ColumnDef } from "@tanstack/react-table";

function getBulletColumn(): ColumnDef<Model> {
  return {
    id: "_bullet",
    cell: ({ row }) => {
      return <Bullet />;
    },
    enableHiding: false,
    enableSorting: false,
    meta: {
      className: cn(
        "w-8 max-w-8 min-w-8 pl-2",
        "hover:w-12 hover:max-w-12 hover:min-w-12",
        "transition-[min-width,width,max-width] duration-300",
      ),
    },
  };
}

export default getBulletColumn;
