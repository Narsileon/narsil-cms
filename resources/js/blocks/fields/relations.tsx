import { type ColumnDef, type RowSelectionState } from "@tanstack/react-table";
import { flatMap, isArray } from "lodash";
import { useEffect, useState } from "react";
import { route } from "ziggy-js";

import { Badge, Button, DataTable, Spinner } from "@narsil-cms/blocks";
import {
  DataTableProvider,
  getSelectColumn,
} from "@narsil-cms/components/data-table";
import {
  DialogClose,
  DialogContent,
  DialogFooter,
  DialogHeader,
  DialogPortal,
  DialogRoot,
  DialogTitle,
  DialogTrigger,
} from "@narsil-cms/components/dialog";
import { Icon } from "@narsil-cms/components/icon";
import { InputRoot } from "@narsil-cms/components/input";
import { useLocalization } from "@narsil-cms/components/localization";
import {
  TabsContent,
  TabsList,
  TabsRoot,
  TabsTrigger,
} from "@narsil-cms/components/tabs";
import { cn } from "@narsil-cms/lib/utils";
import type { DataTableCollection, Model } from "@narsil-cms/types";

type TablesState = Record<string, DataTableCollection>;
type ValuesState = Record<string, RowSelectionState>;

type RelationsProps = {
  className?: string;
  collections?: string[];
  disabled?: boolean;
  id: string;
  placeholder?: string;
  value: string | string[];
  setValue: (value: string | string[]) => void;
};

function getSelectedRowsFromValue(value: string[]): ValuesState {
  return value.reduce<ValuesState>((acc, item) => {
    const [collection, id] = item.split("-");

    if (!collection || !id) {
      return acc;
    }

    (acc[collection] ??= {})[id] = true;

    return acc;
  }, {});
}

function getValueFromSelectedRows(selectedRows: ValuesState): string[] {
  return flatMap(selectedRows, (rows, collection) =>
    Object.keys(rows)
      .filter((id) => rows[id])
      .map((id) => `${collection}-${id}`),
  );
}

function Relations({
  className,
  collections,
  disabled,
  id,
  placeholder,
  value,
  setValue,
}: RelationsProps) {
  const { addTranslations, trans } = useLocalization();

  if (!isArray(value)) {
    value = value ? [value] : [];
  }

  const [dataTables, setDataTables] = useState<TablesState>({});
  const [open, setOpen] = useState<boolean>(false);
  const [selectedRows, setSelectedRows] = useState<ValuesState>(
    getSelectedRowsFromValue(value),
  );

  const selectColumn = getSelectColumn();

  useEffect(() => {
    if (!open || !collections || collections.length === 0) return;

    const fetchCollections = async () => {
      for (const collection of collections) {
        try {
          const url = new URL(
            route("collections.index", { collection: collection }),
            window.location.origin,
          );

          url.searchParams.set("_modal", "1");

          const response = await fetch(url.toString(), {
            headers: {
              Accept: "application/json",
            },
          });

          if (!response.ok) {
            throw new Error("Failed to fetch modal");
          }

          const { props } = await response.json();

          addTranslations(props.translations);

          if (props.collection) {
            setDataTables((dataTables) => ({
              ...dataTables,
              [props.title]: props.collection,
            }));
          }
        } catch (error) {
          console.error("Failed to fetch collection:", collection, error);
        }
      }
    };

    fetchCollections();
  }, [collections, open]);

  return (
    <DialogRoot open={open} onOpenChange={setOpen} modal={true}>
      <DialogTrigger asChild={true}>
        <InputRoot
          id={id}
          className={cn(className)}
          aria-expanded={open}
          aria-disabled={disabled}
          role="combobox"
          variant="button"
        >
          {value.length > 0 ? (
            <div className="-ml-1 flex flex-wrap gap-1">
              {value?.map((item, index) => {
                return (
                  <Badge
                    onClose={() =>
                      setValue((value as string[]).filter((x) => x !== item))
                    }
                    key={index}
                  >
                    {item}
                  </Badge>
                );
              })}
            </div>
          ) : (
            (placeholder ?? trans("placeholders.search"))
          )}
          <Icon
            className={cn("ml-2 shrink-0 duration-300")}
            name="chevron-down"
          />
        </InputRoot>
      </DialogTrigger>
      <DialogPortal>
        <DialogContent className="sm:max-w-full" variant="right">
          <DialogHeader className="border-b">
            <DialogTitle>Relations</DialogTitle>
          </DialogHeader>
          {Object.keys(dataTables).length > 0 ? (
            <TabsRoot
              className="grow overflow-y-hidden"
              defaultValue={Object.keys(dataTables)[0]}
              orientation="vertical"
            >
              <TabsList>
                {Object.keys(dataTables).map((id) => {
                  return (
                    <TabsTrigger value={id} key={id}>
                      {id}
                    </TabsTrigger>
                  );
                })}
              </TabsList>
              {Object.entries(dataTables).map(([id, collection]) => {
                const finalColumns: ColumnDef<Model>[] = [
                  selectColumn,
                  ...collection.columns,
                ];

                const finalColumnOrder = ["_select", ...collection.columnOrder];

                return (
                  <TabsContent className="p-0" value={id} key={id}>
                    <DataTableProvider
                      id={collection.meta.id}
                      columns={finalColumns}
                      data={collection.data}
                      initialState={{
                        columnOrder: finalColumnOrder,
                        columnVisibility: collection.columnVisibility,
                      }}
                      state={{
                        rowSelection: selectedRows[collection.meta.id] ?? {},
                      }}
                      onRowSelectionChange={(updater) => {
                        setSelectedRows((prev) => {
                          const oldSelection = prev[collection.meta.id] ?? {};
                          const newSelection =
                            typeof updater === "function"
                              ? updater(oldSelection)
                              : updater;
                          return {
                            ...prev,
                            [collection.meta.id]: newSelection,
                          };
                        });
                      }}
                      key={id}
                    >
                      <DataTable collection={collection} title={id} />
                    </DataTableProvider>
                  </TabsContent>
                );
              })}
            </TabsRoot>
          ) : (
            <Spinner />
          )}
          <DialogFooter className="border-t">
            <DialogClose asChild={true}>
              <Button variant="ghost">{trans("ui.cancel")}</Button>
            </DialogClose>
            <DialogClose asChild={true}>
              <Button
                onClick={() => {
                  const value = getValueFromSelectedRows(selectedRows);

                  setValue(value);
                }}
              >
                {trans("ui.confirm")}
              </Button>
            </DialogClose>
          </DialogFooter>
        </DialogContent>
      </DialogPortal>
    </DialogRoot>
  );
}

export default Relations;
