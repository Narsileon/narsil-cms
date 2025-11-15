import { type UniqueIdentifier } from "@dnd-kit/core";
import { Button, Tooltip, VisuallyHidden } from "@narsil-cms/blocks";
import {
  DialogBody,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogOverlay,
  DialogPortal,
  DialogRoot,
  DialogTitle,
  DialogTrigger,
} from "@narsil-cms/components/dialog";
import { FormProvider, FormRenderer, FormRoot } from "@narsil-cms/components/form";
import { useLocalization } from "@narsil-cms/components/localization";
import type { FormType } from "@narsil-cms/types";
import { get } from "lodash";
import { useState } from "react";
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
  const { trans } = useLocalization();

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
      <DialogPortal>
        <DialogOverlay />
        <DialogContent>
          <DialogHeader className="border-b">
            <DialogTitle>{data?.handle as string}</DialogTitle>
          </DialogHeader>
          <DialogBody>
            <VisuallyHidden>
              <DialogDescription></DialogDescription>
            </VisuallyHidden>
            <FormProvider
              id={form.id}
              action={form.action}
              elements={form.layout}
              method={form.method}
              initialValues={data}
              languageOptions={form.languageOptions}
              render={() => {
                return (
                  <FormRoot className="grid-cols-12 gap-4">
                    {form.layout.map((element, index) => {
                      return <FormRenderer {...element} key={index} />;
                    })}
                  </FormRoot>
                );
              }}
            ></FormProvider>
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
      </DialogPortal>
    </DialogRoot>
  );
}

export default SortableItemForm;
