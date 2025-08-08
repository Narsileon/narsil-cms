import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { get, set } from "lodash";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { VisuallyHidden } from "@narsil-cms/components/ui/visually-hidden";
import {
  Dialog,
  DialogBody,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@narsil-cms/components/ui/dialog";
import {
  FormInputRenderer,
  FormItem,
  FormLabel,
} from "@narsil-cms/components/ui/form";
import type { AnonymousItem } from ".";
import type { FormType } from "@narsil-cms/types/forms";
import type { UniqueIdentifier } from "@dnd-kit/core";

type SortableItemFormProps = {
  children: React.ReactNode;
  form: FormType;
  ids: UniqueIdentifier[];
  item?: Record<string, any>;
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
  const { getLabel } = useLabels();

  const [data, setData] = React.useState<Record<string, any>>(item);
  const [error, setError] = React.useState<string | null>(null);

  const [open, setOpen] = React.useState<boolean>(false);

  function onOpenChange(open: boolean) {
    if (!open) {
      setData(item);
      setError(null);
    }

    setOpen(open);
  }

  return (
    <Dialog open={open} onOpenChange={onOpenChange}>
      <Tooltip tooltip={getLabel("ui.edit")}>
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
          {form.form.map((field, index) => {
            if ("settings" in field) {
              return (
                <FormItem key={index}>
                  <FormLabel required={true}>{field.name}</FormLabel>
                  <FormInputRenderer
                    element={field}
                    value={data[field.handle]}
                    setValue={(value) => {
                      const nextData = { ...data };

                      set(nextData, field.handle, value);

                      setData(nextData);
                    }}
                  />
                  {error && optionValue === field.handle ? (
                    <p className="text-destructive text-sm">{error}</p>
                  ) : null}
                </FormItem>
              );
            }
          })}
        </DialogBody>
        <DialogFooter className="border-t">
          <Button variant="ghost" onClick={() => onOpenChange(false)}>
            {getLabel("ui.cancel")}
          </Button>
          <Button
            onClick={() => {
              const oldUniqueIdentifier = get(item, optionValue ?? "value");
              const newUniqueIdentifier = get(data, optionValue ?? "value");

              if (oldUniqueIdentifier !== newUniqueIdentifier) {
                if (ids.includes(newUniqueIdentifier)) {
                  setError(getLabel("validation.unique"));

                  return;
                }
              }

              onItemChange(data as AnonymousItem);

              onOpenChange(false);
            }}
          >
            {getLabel("ui.save")}
          </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  );
}

export default SortableItemForm;
