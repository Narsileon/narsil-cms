import { getSelectColumn } from "@narsil-cms/components/data-table";
import { Badge } from "@narsil-ui/components/badge";
import { Button } from "@narsil-ui/components/button";
import { Data, DataTable, DataTableProvider } from "@narsil-ui/components/data-table";
import {
  DialogBackdrop,
  DialogClose,
  DialogFooter,
  DialogHeader,
  DialogPopup,
  DialogPortal,
  DialogRoot,
  DialogTitle,
  DialogTrigger,
} from "@narsil-ui/components/dialog";
import { Heading } from "@narsil-ui/components/heading";
import { Icon } from "@narsil-ui/components/icon";
import { InputRoot } from "@narsil-ui/components/input";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-ui/components/section";
import { Spinner } from "@narsil-ui/components/spinner";
import { TabsList, TabsPanel, TabsRoot, TabsTab } from "@narsil-ui/components/tabs";
import { useTranslator } from "@narsil-ui/components/translator";
import { cn } from "@narsil-ui/lib/utils";
import { DataTableCollection } from "@narsil-ui/types";
import { type ColumnDef, type RowSelectionState } from "@tanstack/react-table";
import { flatMap, isArray, isEmpty } from "lodash-es";
import { useEffect, useState } from "react";
import { route } from "ziggy-js";

type TablesState = Record<string, DataTableCollection>;
type ValuesState = Record<string, RowSelectionState>;

type RelationsProps = {
  className?: string;
  collections?: string[];
  disabled?: boolean;
  id: string;
  multiple?: boolean;
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
  multiple = false,
  placeholder,
  value,
  setValue,
}: RelationsProps) {
  const { addTranslations, trans } = useTranslator();

  if (!isArray(value)) {
    value = !isEmpty(value) ? [value] : [];
  }

  const [dataTables, setDataTables] = useState<TablesState>({});
  const [open, setOpen] = useState<boolean>(false);
  const [selectedRows, setSelectedRows] = useState<ValuesState>(getSelectedRowsFromValue(value));

  const selectColumn = getSelectColumn();

  useEffect(() => {
    if (!open || !collections || collections.length === 0) {
      return;
    }

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
      <DialogTrigger
        render={
          <InputRoot
            id={id}
            role="combobox"
            className={cn(className)}
            aria-expanded={open}
            aria-disabled={disabled}
            variant="button"
          >
            {value.length > 0 ? (
              <div className="-ml-1 flex flex-wrap gap-1">
                {value?.map((item, index) => {
                  return (
                    <Badge
                      onClose={() => setValue((value as string[]).filter((x) => x !== item))}
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
            <Icon className={cn("ml-2 shrink-0 duration-300")} name="chevron-down" />
          </InputRoot>
        }
      />
      <DialogPortal>
        <DialogBackdrop />
        <DialogPopup className="sm:max-w-full" variant="right">
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
                    <TabsTab value={id} key={id}>
                      {id}
                    </TabsTab>
                  );
                })}
              </TabsList>
              {Object.entries(dataTables).map(([id, collection]) => {
                const finalColumns: ColumnDef<Data>[] = [selectColumn, ...collection.meta.columns];

                return (
                  <TabsPanel className="p-0" value={id} key={id}>
                    <DataTableProvider
                      columns={finalColumns}
                      data={collection.data}
                      enableMultiRowSelection={multiple}
                      initialState={collection.meta.tableData}
                      state={{
                        rowSelection: selectedRows[collection.meta.tableData.table_name] ?? {},
                      }}
                      onRowSelectionChange={(updater) => {
                        setSelectedRows((prev) => {
                          const oldSelection = prev[collection.meta.tableData.table_name] ?? {};
                          const newSelection =
                            typeof updater === "function" ? updater(oldSelection) : updater;

                          return {
                            ...prev,
                            [collection.meta.tableData.table_name]: newSelection,
                          };
                        });
                      }}
                      key={id}
                    >
                      <SectionRoot className="h-full animate-in gap-4 p-4 fade-in-0">
                        <SectionHeader className="flex items-center justify-between gap-2">
                          <Heading level="h2" variant="h4" className="min-w-1/5">
                            {id}
                          </Heading>
                        </SectionHeader>
                        <SectionContent
                          className="grow overflow-y-auto"
                          render={<DataTable collection={collection} />}
                        />
                      </SectionRoot>
                    </DataTableProvider>
                  </TabsPanel>
                );
              })}
            </TabsRoot>
          ) : (
            <Spinner />
          )}
          <DialogFooter className="border-t">
            <DialogClose render={<Button variant="ghost">{trans("ui.cancel")}</Button>} />
            <DialogClose
              render={
                <Button
                  onClick={() => {
                    const value = getValueFromSelectedRows(selectedRows);

                    setValue(value);
                  }}
                >
                  {trans("ui.confirm")}
                </Button>
              }
            />
          </DialogFooter>
        </DialogPopup>
      </DialogPortal>
    </DialogRoot>
  );
}

export default Relations;
