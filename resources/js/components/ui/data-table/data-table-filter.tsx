import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import { DataTableRowMenu, useDataTable } from "@/components/ui/data-table";
import { ModalLink } from "@/components/ui/modal";
import { route } from "ziggy-js";
import { Toggle } from "@/components/ui/toggle";
import { useLabels } from "@/components/ui/labels";
import type { DataTableFilterCollection } from "@/types";

type DataTableFilterProps = React.ComponentProps<"ul"> &
  DataTableFilterCollection & {};

function DataTableFilter({
  className,
  data,
  meta,
  ...props
}: DataTableFilterProps) {
  const { getLabel } = useLabels();

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
          {getLabel("ui.all")}
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
          <DataTableRowMenu id={category.id} routes={meta.routes} />
        </li>
      ))}
      {meta.routes.create ? (
        <li>
          <Button asChild={true}>
            <ModalLink href={route(meta.routes.create)}>
              {meta.addLabel}
            </ModalLink>
          </Button>
        </li>
      ) : null}
    </ul>
  );
}

export default DataTableFilter;
