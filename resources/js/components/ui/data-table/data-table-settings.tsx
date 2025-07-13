import { Button } from "@/components/ui/button";
import { isString } from "lodash";
import { SettingsIcon } from "lucide-react";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";
import useDataTable from "./data-table-context";
import {
  DropdownMenu,
  DropdownMenuCheckboxItem,
  DropdownMenuContent,
  DropdownMenuPortal,
  DropdownMenuRadioGroup,
  DropdownMenuRadioItem,
  DropdownMenuSub,
  DropdownMenuSubContent,
  DropdownMenuSubTrigger,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";

type DataTableSettingsProps = React.ComponentProps<typeof Button> & {
  options?: string[];
};

function DataTableSettings({
  options = ["10", "25", "50", "100"],
  ...props
}: DataTableSettingsProps) {
  const { getLabel } = useLabels();

  const { dataTable, dataTableStore } = useDataTable();

  return (
    <DropdownMenu>
      <Tooltip tooltip={getLabel("accessibility.toggle_table_settings")}>
        <DropdownMenuTrigger asChild={true}>
          <Button
            aria-label={
              getLabel("accessibility.toggle_table_settings") ??
              "Toggle table settings"
            }
            size="icon"
            variant="outline"
            {...props}
          >
            <SettingsIcon />
          </Button>
        </DropdownMenuTrigger>
      </Tooltip>
      <DropdownMenuContent align="end">
        <DropdownMenuSub>
          <DropdownMenuSubTrigger>
            {getLabel("table.columns")}
          </DropdownMenuSubTrigger>
          <DropdownMenuPortal>
            <DropdownMenuSubContent>
              {dataTable
                .getAllColumns()
                .filter((column) => column.getCanHide())
                .map((column) => {
                  if (!isString(column.columnDef.header)) {
                    return null;
                  }

                  return (
                    <DropdownMenuCheckboxItem
                      checked={column.getIsVisible()}
                      onCheckedChange={(value) =>
                        column.toggleVisibility(!!value)
                      }
                      onSelect={(e) => e.preventDefault()}
                      key={column.id}
                    >
                      {column.columnDef.header}
                    </DropdownMenuCheckboxItem>
                  );
                })}
            </DropdownMenuSubContent>
          </DropdownMenuPortal>
        </DropdownMenuSub>
        <DropdownMenuSub>
          <DropdownMenuSubTrigger>
            {getLabel("pagination.pagination")}
          </DropdownMenuSubTrigger>
          <DropdownMenuPortal>
            <DropdownMenuSubContent>
              <DropdownMenuRadioGroup
                value={dataTableStore.pageSize.toString()}
                onValueChange={(value) =>
                  dataTableStore.setPageSize(Number(value))
                }
              >
                {options.map((option, index) => (
                  <DropdownMenuRadioItem value={option} key={index}>
                    {option}
                  </DropdownMenuRadioItem>
                ))}
              </DropdownMenuRadioGroup>
            </DropdownMenuSubContent>
          </DropdownMenuPortal>
        </DropdownMenuSub>
      </DropdownMenuContent>
    </DropdownMenu>
  );
}

export default DataTableSettings;
