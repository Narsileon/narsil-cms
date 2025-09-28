import { type UniqueIdentifier } from "@dnd-kit/core";
import { get, set } from "lodash";
import { useState } from "react";

import { Button, Tooltip, VisuallyHidden } from "@narsil-cms/blocks";
import {
  DialogBody,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogRoot,
  DialogTitle,
  DialogTrigger,
} from "@narsil-cms/components/dialog";
import { FormItem, FormLabel } from "@narsil-cms/components/form";
import { useLabels } from "@narsil-cms/components/labels";
import { getField } from "@narsil-cms/plugins/fields";
import type { FormType } from "@narsil-cms/types";

import { type AnonymousItem } from ".";

type SortableItemFormProps = {
  children: React.ReactNode;
  form: FormType;
  ids: UniqueIdentifier[];
  item?: Record<string, unknown>;
  optionValue: string;
  onItemChange: (value: AnonymousItem) => void;
};

function SortableItemForm({
  children,
  form,
  ids,
  item = {},
  optionValue,
  onItemChange,
  ...props
}: SortableItemFormProps) {
  const { trans } = useLabels();

  const [data, setData] = useState<Record<string, unknown>>(item);
  const [error, setError] = useState<string | null>(null);

  const [open, setOpen] = useState<boolean>(false);

  function onOpenChange(open: boolean) {
    if (!open) {
      setData(item);
      setError(null);
    }

    setOpen(open);
  }

  return (
    <DialogRoot open={open} onOpenChange={onOpenChange}>
      <Tooltip tooltip={trans("ui.edit")}>
        <DialogTrigger asChild={true} {...props}>
          {children}
        </DialogTrigger>
      </Tooltip>
      <DialogContent>
        <DialogHeader className="border-b">
          <DialogTitle>{form.title}</DialogTitle>
        </DialogHeader>
        <DialogBody>
          <VisuallyHidden>
            <DialogDescription></DialogDescription>
          </VisuallyHidden>
          {form.layout.map((field, index) => {
            if ("settings" in field) {
              return (
                <FormItem key={index}>
                  <FormLabel required={true}>{field.name}</FormLabel>
                  {getField(field.type, {
                    id: field.handle,
                    element: field,
                    value: data[field.handle],
                    setValue: (value) => {
                      const nextData = { ...data };

                      set(nextData, field.handle, value);

                      setData(nextData);
                    },
                  })}
                  {error && optionValue === field.handle ? (
                    <p className="text-destructive">{error}</p>
                  ) : null}
                </FormItem>
              );
            }
          })}
        </DialogBody>
        <DialogFooter className="border-t">
          <Button variant="ghost" onClick={() => onOpenChange(false)}>
            {trans("ui.cancel")}
          </Button>
          <Button
            onClick={() => {
              const oldUniqueIdentifier = get(item, optionValue ?? "value");
              const newUniqueIdentifier = get(data, optionValue ?? "value");

              if (oldUniqueIdentifier !== newUniqueIdentifier) {
                if (ids.includes(newUniqueIdentifier)) {
                  setError(trans("validation.unique"));

                  return;
                }
              }

              onItemChange(data as AnonymousItem);

              onOpenChange(false);
            }}
          >
            {trans("ui.save")}
          </Button>
        </DialogFooter>
      </DialogContent>
    </DialogRoot>
  );
}

export default SortableItemForm;
