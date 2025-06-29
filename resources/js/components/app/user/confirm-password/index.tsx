import { Input } from "@/components/ui/input";
import { route } from "ziggy-js";
import useTranslationsStore from "@/stores/translations-store";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogProps,
  DialogTitle,
} from "@/components/ui/dialog";
import {
  Form,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
  FormProvider,
  FormSubmit,
} from "@/components/ui/form";

type UserConfirmPasswordProps = Required<
  Pick<DialogProps, "open" | "onOpenChange">
> & {
  onConfirmed: () => void;
};

function UserConfirmPassword({
  open,
  onConfirmed,
  onOpenChange,
}: UserConfirmPasswordProps) {
  const { trans } = useTranslationsStore();

  return (
    <Dialog open={open} onOpenChange={onOpenChange}>
      <DialogContent className="sm:w-sm">
        <DialogHeader>
          <DialogTitle>
            {trans("ui.password_confirm", "Confirm password")}
          </DialogTitle>
        </DialogHeader>
        <FormProvider
          id="user-confirm-password-form"
          initialData={{
            password: "",
          }}
          render={() => (
            <Form
              className="grid gap-6"
              autoComplete="off"
              method="post"
              options={{
                onSuccess: () => {
                  onConfirmed();

                  onOpenChange(false);
                },
              }}
              url={route("password.confirm")}
            >
              <FormField
                name="password"
                render={({ onChange, ...field }) => (
                  <FormItem>
                    <FormLabel required={true} />
                    <Input
                      autoComplete="one-time-code"
                      type="password"
                      onChange={(e) => onChange(e.target.value)}
                      {...field}
                    />
                    <FormMessage />
                  </FormItem>
                )}
              />
              <FormSubmit>{trans("ui.confirm", "Confirm")}</FormSubmit>
            </Form>
          )}
        />
      </DialogContent>
    </Dialog>
  );
}

export default UserConfirmPassword;
