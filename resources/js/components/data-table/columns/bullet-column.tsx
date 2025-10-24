import { Bullet } from "@narsil-cms/components/bullet";
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
      className: "min-w-8 w-8 max-w-8 hover:w-12 hover:min-w-12 hover:max-w-12 pl-2 duration-300",
    },
  };
}

export default getBulletColumn;
