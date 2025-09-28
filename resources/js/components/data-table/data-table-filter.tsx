import { type ComponentProps } from "react";
import { route } from "ziggy-js";

import { Button, Toggle } from "@narsil-cms/blocks";
import {
  DataTableRowMenu,
  useDataTable,
} from "@narsil-cms/components/data-table";
import { useLabels } from "@narsil-cms/components/labels";
import { cn } from "@narsil-cms/lib/utils";
import type { DataTableFilterCollection } from "@narsil-cms/types";

type DataTableFilterProps = ComponentProps<"ul"> &
  DataTableFilterCollection & {};

function DataTableFilter({
  className,
  data,
  meta,
  ...props
}: DataTableFilterProps) {
  const { trans } = useLabels();

  const { dataTableStore } = useDataTable();

  return (
    <ul className={cn("grid gap-2", className)} {...props}>
      <li>
        <Toggle
          className="w-full justify-start font-normal"
          pressed={!dataTableStore.filter}
          onClick={() => {
            dataTableStore.setFilter(null);
          }}
        >
          {trans("ui.all")}
        </Toggle>
      </li>
      {data.map((category) => (
        <li
          className="flex items-center justify-between gap-2"
          key={category.id}
        >
          <Toggle
            className="grow justify-start font-normal"
            pressed={category.id.toString() === dataTableStore.filter}
            onClick={() => {
              dataTableStore.setFilter(category.id.toString());
            }}
          >
            {category.label}
          </Toggle>
          <DataTableRowMenu
            id={category.id}
            modal={true}
            routes={meta.routes}
          />
        </li>
      ))}
      {meta.routes.create ? (
        <li className="mt-2">
          <Button
            asChild={true}
            linkProps={{
              href: route(meta.routes.create, meta.routes.params),
              modal: true,
            }}
          >
            {meta.addLabel}
          </Button>
        </li>
      ) : null}
    </ul>
  );
}

export default DataTableFilter;
