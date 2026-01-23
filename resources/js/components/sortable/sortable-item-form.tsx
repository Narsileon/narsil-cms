import { type UniqueIdentifier } from "@dnd-kit/core";
import { Button } from "@narsil-cms/blocks/button";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { VisuallyHidden } from "@narsil-cms/blocks/visually-hidden";
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
import { FormProvider, FormRoot, FormSteps } from "@narsil-cms/components/form";
import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";
import type { FormType } from "@narsil-cms/types";
import { get } from "lodash-es";
import { type ReactNode, useState } from "react";
import { type AnonymousItem } from ".";

type SortableItemFormProps = {
  children: ReactNode;
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

          <FormProvider
            id={form.id}
            action={form.action}
            elements={form.tabs}
            method={form.method}
            initialValues={data}
            languageOptions={form.languageOptions}
            render={({ data }) => {
              return (
                <>
                  <DialogBody className={cn(form.tabs.length > 1 && "p-0")}>
                    <VisuallyHidden>
                      <DialogDescription></DialogDescription>
                    </VisuallyHidden>
                    <FormRoot className="grid-cols-12 gap-4">
                      <FormSteps tabs={form.tabs} />
                    </FormRoot>
                  </DialogBody>
                  <DialogFooter className="border-t">
                    <Button variant="ghost" onClick={() => onOpenChange(false)}>
                      {trans("ui.cancel")}
                    </Button>
                    <Button
                      onClick={() => {
                        const oldUniqueIdentifier = get(
                          item,
                          optionValue ?? "value",
                        ) as UniqueIdentifier;
                        const newUniqueIdentifier = get(
                          data,
                          optionValue ?? "value",
                        ) as UniqueIdentifier;

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
                </>
              );
            }}
          />
        </DialogContent>
      </DialogPortal>
    </DialogRoot>
  );
}

export default SortableItemForm;
