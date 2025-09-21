import { isArray } from "lodash";
import { useEffect, useState } from "react";
import { route } from "ziggy-js";

import { Badge, Card, DataTable } from "@narsil-cms/blocks";
import { DataTableProvider } from "@narsil-cms/components/data-table";
import {
  DialogContent,
  DialogPortal,
  DialogRoot,
  DialogTrigger,
} from "@narsil-cms/components/dialog";
import { Icon } from "@narsil-cms/components/icon";
import { InputRoot } from "@narsil-cms/components/input";
import { useLabels } from "@narsil-cms/components/labels";
import { cn } from "@narsil-cms/lib/utils";
import { type DataTableCollection } from "@narsil-cms/types";

type RelationsProps = {
  className?: string;
  collections?: string[];
  disabled?: boolean;
  id: string;
  placeholder?: string;
  value: string | string[];
  setValue: (value: string | string[]) => void;
};

function Relations({
  className,
  collections,
  disabled,
  id,
  placeholder,
  value,
  setValue,
}: RelationsProps) {
  const { trans } = useLabels();

  if (!isArray(value)) {
    value = value ? [value] : [];
  }

  const [open, setOpen] = useState<boolean>(false);

  const [dataTables, setDataTables] = useState<
    Record<string, DataTableCollection>
  >({});

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

          if (props.collection) {
            setDataTables((dataTables) => ({
              ...dataTables,
              [collection]: props.collection,
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
    <DialogRoot open={open} onOpenChange={setOpen} modal>
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
            <div className="flex flex-wrap gap-1">
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
        <DialogContent className="p-0">
          <Card
            footerButtons={[
              {
                label: trans("ui.cancel"),
                variant: "secondary",
              },
              {
                label: trans("ui.confirm"),
              },
            ]}
            footerProps={{
              className: "justify-between border-t",
            }}
          >
            {Object.entries(dataTables).map(([id, collection]) => {
              return (
                <DataTableProvider
                  id={collection.meta.id}
                  columns={collection.columns}
                  data={collection.data}
                  initialState={{
                    columnOrder: collection.columnOrder,
                    columnVisibility: collection.columnVisibility,
                  }}
                  render={({ dataTable }) => (
                    <DataTable dataTable={dataTable} />
                  )}
                  key={id}
                />
              );
            })}
          </Card>
        </DialogContent>
      </DialogPortal>
    </DialogRoot>
  );
}

export default Relations;
